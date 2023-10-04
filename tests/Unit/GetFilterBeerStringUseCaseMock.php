<?php

namespace App\Tests\Unit;

use App\Application\Interfaces\BeerApiFilterStringInterface;
use App\Domain\Beer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetFilterBeerStringUseCaseMock implements BeerApiFilterStringInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get an array of beer objects from our mock API by filtering on a string
     * @return array
     */
    public function filterByString(string $character): array
    {
        $response = $this->httpClient->request('GET', 'https://example.com/api/data');
        $fakeResponseData = $response->getContent();

        $beers = json_decode($fakeResponseData, true);

        $filteredData = [];
        foreach ($beers as $beer) {
            $foods = $beer['food_pairing'];
            foreach ($foods as $food) {
                if (strpos($food, $character) !== false) {
                    $filteredData[] = new Beer(
                        $beer['id'],
                        $beer['name'],
                        $beer['tagline'],
                        $beer['first_brewed'],
                        $beer['description'],
                        $beer['image_url']
                    );
                }
            }
        }
        return $filteredData;
    }
}
