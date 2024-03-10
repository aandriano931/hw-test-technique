<?php

declare(strict_types=1);

class CompanyDTO
{
    public function __construct(
        private ?string $nom = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return CompanyDTO
     */
    public function setNom(?string $nom): CompanyDTO
    {
        $this->nom = $nom;
        return $this;
    }
}
