<?php

declare(strict_types=1);

namespace App\Command\FranceTravail;

use App\DataTransformer\FranceTravail\JobOfferDataTransformer;
use App\Entity\JobOffer;
use App\Repository\JobOfferRepository;
use App\Service\FranceTravail\OffresEmploiApi\Client;
use JobOfferDTO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Throwable;

use function count;
use function explode;
use function is_array;
use function json_encode;

#[AsCommand(
    name: 'app:ft:import-offers',
    description: 'Import job offers from FranceTravail API.',
    hidden: false,
)]
final class ImportJobOffersCommand extends Command
{
    public function __construct(
        private readonly Client $apiClient,
        private readonly JobOfferDataTransformer $dataTransformer,
        private readonly JobOfferRepository $jobOfferRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'commune',
                null,
                InputOption::VALUE_REQUIRED,
                'The INSEE code of the commune concerned by the job offers.'
            )
        ;
    }

    /**
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $queryParameters = [];
        if ($input->getOption('commune') !== null) {
            $queryParameters['commune'] = $input->getOption('commune');
        }

        // First query to get headers and guess ranges from them
        $initialResponse = $this->apiClient->request(
            'GET',
            'search',
            $queryParameters
        );

        $headers = $initialResponse->getHeaders();
        $ranges = $this->getRangesFromHeaders($headers);

        //$this->jobOfferRepository->cleanAll(); //@Todo Used to clean database during development

        $io->info("Starting to import job offers.");
        $apiOffers = $this->getJobOffersFromApi($io, $ranges, $queryParameters);
        $databaseOffers = $this->jobOfferRepository->findAll();

        $newOffers = $updatedOffers = [];
        foreach ($apiOffers as $apiOffer) {
            $isNewOffer = true;
            foreach ($databaseOffers as $databaseOffer) {
                if ($apiOffer->getFranceTravailId() === $databaseOffer->getFranceTravailId()) {
                    $isNewOffer = false;
                    if ($apiOffer->getUpdatedAt() > $databaseOffer->getUpdatedAt()) {
                        $updatedOffers[] = $apiOffer;
                    }
                    break;
                }
            }
            if ($isNewOffer) {
                $newOffers[] = $apiOffer;
            }
        }

        $this->jobOfferRepository->persistMany($newOffers);
        $io->info(count($newOffers) . " offer(s) were inserted into the database.");
        $this->jobOfferRepository->persistMany($updatedOffers);
        $io->info(count($updatedOffers) . " offer(s) were updated into the database.");

        //@TODO Créer le rapport de stats sur l'import (csv ou autre)

        //@TODO Cette commande mérite une meilleure gestion des erreurs

        return Command::SUCCESS;

    }

    /**
     * @param SymfonyStyle $io
     * @param array        $ranges
     * @param array        $queryParameters
     * @return array<JobOffer>
     * @throws Throwable
     */
    private function getJobOffersFromApi(SymfonyStyle $io, array $ranges, array $queryParameters): array
    {
        $jobOffers = [];
        foreach ($ranges as $range) {
            $io->info("Importing job offers range $range.");
            $queryParameters['range'] = $range;
            $response = $this->apiClient->request(
                'GET',
                'search',
                $queryParameters
            );
            $content = $response->toArray();
            if (isset($content['resultats']) && $content['resultats'] !== []) {
                $encoders = [new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];
                $serializer = new Serializer($normalizers, $encoders);
                foreach ($content['resultats'] as $offerData) {
                    $offerDTO = $serializer->deserialize(json_encode($offerData), JobOfferDTO::class, 'json');
                    //@Todo ajouter une validation via annotation sur le DTO
                    $offer = $this->dataTransformer->transform($offerDTO);
                    $jobOffers[] = $offer;
                }
            }
        }

        return $jobOffers;
    }

    /**
     * @TODO Ce code mériterait d'être plus clair et plus robuste j'en suis conscient
     * @param array $headers
     * @return array<string>
     */
    private function getRangesFromHeaders(array $headers): array
    {
        $ranges = [];
        $range = $total = 0;
        // We
        if (isset($headers['accept-range']) && is_array($headers['accept-range'])) {
            $range = (int) $headers['accept-range'][0];
        }
        // We extract the value of the total results from the content-range header
        if (isset($headers['content-range']) && is_array($headers['content-range'])) {
            $parts = explode('/', $headers['content-range'][0]);
            if (count($parts) === 2) {
                $total = (int) $parts[1];
                //@TODO Hack pour contrer la limite haute découverte sur la fin
                if ($total > 3000) {
                    $total = 3000;
                }
            } else {
                return [];
            }
        }
        if ($range !== 0 && $total !== 0) {
            $i = 0;
            while ($i < $total) {
                $max = $i + ($range-1);
                $ranges[] = "$i-$max";
                $i += $range;
            }
        }

        return $ranges;
    }
}
