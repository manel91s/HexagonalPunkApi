<?php

namespace App\Infrastructure\Http;

use App\Application\GetFilterBeerByStringUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * Gets beers in filter food pairing
     * @return JsonResponse
     */
    #[Route('/beer', methods: ['GET'])]
    public function getBeerByFood(
        Request $request,
        GetFilterBeerByStringUseCase $getFilterBeerByStringUseCase
    ): JsonResponse {

        try {

            $beers = $getFilterBeerByStringUseCase->filterByString(
                str_replace(' ', '_', $request->query->get('food'))
            );

            return $this->json([
                'data' => $this->serializeObjects($beers)
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
