<?php

declare(strict_types=1);

class OfferOriginDTO
{
    public function __construct(
        private ?string $urlOrigine = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getUrlOrigine(): ?string
    {
        return $this->urlOrigine;
    }

    /**
     * @param string|null $urlOrigine
     * @return OfferOriginDTO
     */
    public function setUrlOrigine(?string $urlOrigine): OfferOriginDTO
    {
        $this->urlOrigine = $urlOrigine;
        return $this;
    }
}
