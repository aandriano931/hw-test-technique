<?php

declare(strict_types=1);

namespace App\Service\FranceTravail\OffresEmploiApi;

use App\Exception\BearerTokenException;
use Doctrine\DBAL\Exception;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

final class Client implements ApiClientInterface
{
    public function __construct(
        private readonly HttpClientInterface   $client,
        private CacheInterface                 $cache,
        private readonly AuthenticationManager $authenticationManager,
        private readonly string                $baseUri,
    ) {
        $this->cache = new FilesystemAdapter('app.bearer_token_cache');
    }

    /**
     * @throws Throwable
     */
    private function getBearerToken(): string
    {
        $cachedToken = $this->cache->getItem('bearer_token');
        if (!$cachedToken->isHit()) {
            $token = $this->authenticationManager->fetchBearerTokenFromAuthEndpoint();
            if (is_null($token)) {
                throw new BearerTokenException();
            }
            $cachedToken->set($token);
            $cachedToken->expiresAfter(1500);
            $this->cache->save($cachedToken);
        } else {
            $token = $cachedToken->get();
        }

        return $token;
    }

    /**
     * @throws Throwable
     */
    public function request(string $method, string $endpoint, array $parameters=[]): ResponseInterface
    {
        $token = $this->getBearerToken();
        $response = $this->client->request(
            $method,
            "$this->baseUri/$endpoint",
            [
                'auth_bearer' => "$token",
                'query' => $parameters,
            ]
        );
        if ($response->getStatusCode() >= 400) {
            $content = $response->toArray();
            throw new Exception($content['message'], $response->getStatusCode());
            //@Todo Gérer proprement l'erreur
        }

        return $response;
    }
}
