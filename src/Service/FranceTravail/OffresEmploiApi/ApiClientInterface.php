<?php

declare(strict_types=1);

namespace App\Service\FranceTravail\OffresEmploiApi;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiClientInterface
{
    public function request(string $method, string $endpoint, array $parameters=[]): ResponseInterface;
}
