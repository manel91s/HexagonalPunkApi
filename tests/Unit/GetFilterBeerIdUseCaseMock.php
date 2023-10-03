<?php

namespace App\Tests\Unit;

use App\Application\Interfaces\BeerApiFilterIdInterface;
use App\Domain\Beer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerIdUseCaseMock implements BeerApiFilterIdInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get an object beer from our mock API by filtering on a id
     * @return Beer
     */
    public function filterById(int $id): ?Beer
    {
        $response = $this->httpClient->request('GET', 'https://example.com/api/data');
        $fakeResponseData = $response->getContent();

        $beers = json_decode($fakeResponseData, true);

        foreach ($beers as $beer) {
            if ($beer['id'] === $id) {
                return new Beer(
                    $beer['id'],
                    $beer['name'],
                    $beer['tagline'],
                    $beer['first_brewed'],
                    $beer['description'],
                    $beer['image_url']
                );
            }
        }
        return null;
    }
}
