<?php

namespace App\Tests\Unit;

use App\Domain\Beer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetFilterBeerIdUseCaseTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Check the id filter in Mock APi
     */
    public function testGetFilterData(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $jsonPath = __DIR__ . '/../../jsons/punk_api_mock.json';
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getContent')->willReturn(file_get_contents($jsonPath));
        $httpClientMock->method('request')->willReturn($responseMock);

        $getFilterBeerByStringUsecase = new GetFilterBeerIdUseCaseMock($httpClientMock);

        $id = 5;
        $result = $getFilterBeerByStringUsecase->filterById($id);

        $this->assertInstanceOf(Beer::class, $result);
    }
}
