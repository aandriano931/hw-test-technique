<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

/**
 * @extends ServiceEntityRepository<JobOffer>
 *
 * @method JobOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobOffer[]    findAll()
 * @method JobOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    /**
     * @param array<JobOffer> $offers
     * @return void
     * @throws Throwable
     */
    public function persistMany(array $offers): void
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->beginTransaction();
            foreach ($offers as $offer) {
                $entityManager->persist($offer);
            }
            $entityManager->flush();
            $entityManager->commit();
        } catch (Throwable $e) {
            $entityManager->getConnection()->rollBack();
            //@TODO Ajouter des logs
            throw $e;
        }
    }

    /**
     * Méthode utilisée pendant la phase de développement
     * @return void
     * @throws Throwable
     */
    public function cleanAll(): void
    {
        $entityManager = $this->getEntityManager();
        try {
            $query = $entityManager->createQuery('DELETE FROM ' . JobOffer::Class);
            $query->execute();
        } catch (Throwable $e) {
            //@TODO Ajouter des logs
            throw $e;
        }
    }

}
