<?php

declare(strict_types=1);

class JobOfferDTO
{
    public function __construct(
        private ?string         $id = null,
        private ?string         $dateActualisation = null,
        private ?string         $dateCreation = null,
        private ?string         $description = null,
        private ?CompanyDTO     $entreprise = null,
        private ?string         $intitule = null,
        private ?string         $typeContrat = null,
        private ?OfferOriginDTO $origineOffre = null,
        private ?string         $secteurActiviteLibelle = null,
        private ?SalaryDTO      $salaire = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return JobOfferDTO
     */
    public function setId(?string $id): JobOfferDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateActualisation(): ?string
    {
        return $this->dateActualisation;
    }

    /**
     * @param string|null $dateActualisation
     * @return JobOfferDTO
     */
    public function setDateActualisation(?string $dateActualisation): JobOfferDTO
    {
        $this->dateActualisation = $dateActualisation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreation(): ?string
    {
        return $this->dateCreation;
    }

    /**
     * @param string|null $dateCreation
     * @return JobOfferDTO
     */
    public function setDateCreation(?string $dateCreation): JobOfferDTO
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return JobOfferDTO
     */
    public function setDescription(?string $description): JobOfferDTO
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return CompanyDTO|null
     */
    public function getEntreprise(): ?CompanyDTO
    {
        return $this->entreprise;
    }

    /**
     * @param CompanyDTO|null $entreprise
     * @return JobOfferDTO
     */
    public function setEntreprise(?CompanyDTO $entreprise): JobOfferDTO
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    /**
     * @param string|null $intitule
     * @return JobOfferDTO
     */
    public function setIntitule(?string $intitule): JobOfferDTO
    {
        $this->intitule = $intitule;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    /**
     * @param string|null $typeContrat
     * @return JobOfferDTO
     */
    public function setTypeContrat(?string $typeContrat): JobOfferDTO
    {
        $this->typeContrat = $typeContrat;
        return $this;
    }

    /**
     * @return SalaryDTO|null
     */
    public function getSalaire(): ?SalaryDTO
    {
        return $this->salaire;
    }

    /**
     * @param SalaryDTO|null $salaire
     * @return JobOfferDTO
     */
    public function setSalaire(?SalaryDTO $salaire): JobOfferDTO
    {
        $this->salaire = $salaire;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecteurActiviteLibelle(): ?string
    {
        return $this->secteurActiviteLibelle;
    }

    /**
     * @param string|null $secteurActiviteLibelle
     * @return JobOfferDTO
     */
    public function setSecteurActiviteLibelle(?string $secteurActiviteLibelle): JobOfferDTO
    {
        $this->secteurActiviteLibelle = $secteurActiviteLibelle;
        return $this;
    }

    /**
     * @return OfferOriginDTO|null
     */
    public function getOrigineOffre(): ?OfferOriginDTO
    {
        return $this->origineOffre;
    }

    /**
     * @param OfferOriginDTO|null $origineOffre
     * @return JobOfferDTO
     */
    public function setOrigineOffre(?OfferOriginDTO $origineOffre): JobOfferDTO
    {
        $this->origineOffre = $origineOffre;
        return $this;
    }
}
