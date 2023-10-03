<?php

namespace App\Application;

use App\Application\Interfaces\BeerApiFilterStringInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerByStringUseCase implements BeerApiFilterStringInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function filterByString(string $character): array
    {
        return [];
    }
}
