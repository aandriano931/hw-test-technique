<?php

declare(strict_types=1);

namespace App\Service\FranceTravail\OffresEmploiApi;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class AuthenticationManager implements BearerTokenAuthenticationInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string              $authenticationUri,
        private readonly string              $clientId,
        private readonly string              $clientSecret,
        private readonly string              $scope,
    ) {
    }

    public function fetchBearerTokenFromAuthEndpoint(): ?string
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->authenticationUri,
                [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'body' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'scope' => $this->scope,
                    ],
                ]
            );
            $content = $response->getContent();
            $data = json_decode($content, true);

            return $data['access_token'] ?? null;
        }  catch (Throwable $e) {
            //@Todo Logger l'exception
            return null;
        }
    }

}
