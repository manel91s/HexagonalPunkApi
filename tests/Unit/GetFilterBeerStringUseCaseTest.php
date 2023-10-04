<?php

namespace App\Tests\Unit;

use App\Domain\Beer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetFilterBeerByStringUseCaseTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Check the chain filter in Mock APi
     */
    public function testGetFilterData(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $jsonPath = __DIR__ . '/../../jsons/punk_api_mock.json';
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getContent')->willReturn(file_get_contents($jsonPath));
        $httpClientMock->method('request')->willReturn($responseMock);

        $getFilterBeerByStringUsecase = new GetFilterBeerStringUseCaseMock($httpClientMock);

        $food = 'Spicy';
        $result = $getFilterBeerByStringUsecase->filterByString($food);

        $this->assertContainsOnlyInstancesOf(Beer::class, $result);
    }
}
