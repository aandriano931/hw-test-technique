<?php

declare(strict_types=1);

namespace App\DataTransformer\FranceTravail;

use App\DataTransformer\DataTransformerInterface;
use App\Entity\JobOffer;
use App\Helper\ISO8601Converter;
use JobOfferDTO;

class JobOfferDataTransformer implements DataTransformerInterface
{
    public function transform(JobOfferDTO $jobOfferDTO): JobOffer
    {
        $jobOffer = new JobOffer();
        $jobOffer->setFranceTravailId($jobOfferDTO->getId());
        $jobOffer->setActivitySector($jobOfferDTO->getSecteurActiviteLibelle());
        $jobOffer->setCompanyName($jobOfferDTO->getEntreprise()?->getNom());
        $jobOffer->setApplyUrl($jobOfferDTO->getOrigineOffre()?->getUrlOrigine());
        $jobOffer->setContractType($jobOfferDTO->getTypeContrat());
        $jobOffer->setDescription($jobOfferDTO->getDescription());
        $jobOffer->setLabel($jobOfferDTO->getIntitule());
        $jobOffer->setSalary($jobOfferDTO->getSalaire()?->getLibelle());
        $creationDate = ISO8601Converter::convertISOToDateTime($jobOfferDTO->getDateCreation());
        if ($creationDate !== false) {
            $jobOffer->setCreatedAt($creationDate);
        }
        $modificationDate = ISO8601Converter::convertISOToDateTime($jobOfferDTO->getDateActualisation());
        if ($modificationDate !== false) {
            $jobOffer->setUpdatedAt($creationDate);
        }

        return $jobOffer;
    }

}
