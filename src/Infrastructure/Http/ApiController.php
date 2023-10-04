<?php

namespace App\Infrastructure\Http;

use App\Application\GetFilterBeerByIdUseCase;
use App\Application\GetFilterBeerByStringUseCase;
use App\Domain\Beer;
use OpenApi\Attributes\QueryParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class ApiController extends AbstractController
{
    #[Route('/beers', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return beers by food',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Beer::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'food',
        in: 'query',
        description: 'The field used to filter beer by food pairing',
        schema: new OA\Schema(type: 'string')
    )]
    public function getBeerByFood(
        Request $request,
        GetFilterBeerByStringUseCase $getFilterBeerByStringUseCase,
        CacheInterface $cache
    ): JsonResponse {

        try {
            $food = str_replace(' ', '_', $request->query->get('food'));
            $cacheKey = 'beer_cache_' . $food;

            $cachedData = $cache->get(
                $cacheKey,
                function (ItemInterface $item) use ($getFilterBeerByStringUseCase, $food) {

                    $beers = $getFilterBeerByStringUseCase->filterByString($food);

                    $item->expiresAfter(3600);

                    return $beers;
                }
            );

            return $this->json([
                'data' => $this->serializeObjects($cachedData)
            ], Response::HTTP_OK);
        } catch (BadRequestException $e) {
            return $this->json(['msg' => $e->getMessage()], $e->getCode());
        }
    }

    #[Route('/beer/{id}', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return beer by id',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Beer::class, groups: ['full']))
        )
    )]
    public function getBeerById(
        Request $request,
        GetFilterBeerByIdUseCase $getFilterBeerByIdUseCase,
        CacheInterface $cache
    ): JsonResponse {

        try {

            $id = intval($request->attributes->get('id'));
            $cacheKey = 'beer_cache_' . $id;

            $beerCatched = $cache->get(
                $cacheKey,
                function (ItemInterface $item) use ($getFilterBeerByIdUseCase, $id) {

                    $beer = $getFilterBeerByIdUseCase->filterById($id);

                    $item->expiresAfter(3600);

                    return $beer;
                }
            );

            return $this->json([
                'id' => $beerCatched->getId(),
                'name' => $beerCatched->getName(),
                'tagline' => $beerCatched->getTagline(),
                'first_brewed' => $beerCatched->getFirstBrewed(),
                'description' => $beerCatched->getDescription(),
                'image' => $beerCatched->getImage()
            ], Response::HTTP_OK);
        } catch (BadRequestException $e) {
            return $this->json(['msg' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Serializes object data
     * @return array
     */
    private function serializeObjects(array $beers): array
    {
        $serializeBeer = [];
        foreach ($beers as $beer) {
            $serializeBeer[] = [
                'id' => $beer->getId(),
                'name' => $beer->getName(),
                'tagline' => $beer->getTagline(),
                'first_brewed' => $beer->getFirstBrewed(),
                'description' => $beer->getDescription(),
                'image' => $beer->getImage()
            ];
        }
        return $serializeBeer;
    }
}
