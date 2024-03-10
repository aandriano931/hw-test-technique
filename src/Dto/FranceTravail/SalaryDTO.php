<?php

declare(strict_types=1);

class SalaryDTO
{
    public function __construct(
        private ?string $libelle = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param string|null $libelle
     * @return SalaryDTO
     */
    public function setLibelle(?string $libelle): SalaryDTO
    {
        $this->libelle = $libelle;
        return $this;
    }
}
