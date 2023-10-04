<?php

namespace App\Application;

use App\Application\Interfaces\BeerApiFilterStringInterface;
use App\Domain\Beer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerByStringUseCase implements BeerApiFilterStringInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Filter by a string in the api
     */
    public function filterByString(string $characters): array
    {
        try {

            $response = $this->httpClient->request(
                'GET',
                'https://api.punkapi.com/v2/beers?food=' . $characters
            );
            $beers = $response->toArray();

            if (!$beers) {
                throw new BadRequestException('Beer not found', Response::HTTP_NOT_FOUND);
            }

            $beersObject = [];
            foreach ($beers as $beer) {
                $beersObject[] = new Beer(
                    $beer['id'],
                    $beer['name'],
                    $beer['tagline'],
                    $beer['first_brewed'],
                    $beer['description'],
                    $beer['image_url']
                );
            }
            return $beersObject;
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode());
        }
    }
}
