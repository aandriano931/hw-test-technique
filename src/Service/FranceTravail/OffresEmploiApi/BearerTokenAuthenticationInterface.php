<?php

declare(strict_types=1);

namespace App\Service\FranceTravail\OffresEmploiApi;

interface BearerTokenAuthenticationInterface
{
    public function fetchBearerTokenFromAuthEndpoint(): ?string;
}
