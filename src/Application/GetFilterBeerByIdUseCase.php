<?php

namespace App\Application;

use App\Application\Interfaces\BeerApiFilterIdInterface;
use App\Domain\Beer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerByIdUseCase implements BeerApiFilterIdInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function filterById(int $id): ?Beer
    {
        try {

            $response = $this->httpClient->request(
                'GET',
                'https://api.punkapi.com/v2/beers/' . $id
            );
            $beer = current($response->toArray());

            if (!$beer) {
                throw new BadRequestException('Beer not found', Response::HTTP_NOT_FOUND);
            }

            return new Beer(
                $beer['id'],
                $beer['name'],
                $beer['tagline'],
                $beer['first_brewed'],
                $beer['description'],
                $beer['image_url']
            );
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode());
        }
    }
}

