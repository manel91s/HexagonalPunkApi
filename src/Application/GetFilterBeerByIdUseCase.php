<?php

namespace App\Application;

use App\Application\Interfaces\BeerApiFilterIdInterface;
use App\Domain\Beer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerByStringUseCase implements BeerApiFilterIdInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function filterById(int $character): ?Beer
    {
        return null;
    }
}

