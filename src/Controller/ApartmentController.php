<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\UseCaseEnum;
use App\Service\UseCaseService;
use App\UseCase\UseCaseCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/apartments")]
final class ApartmentController
{
    #[Route(name: "apartment_create", methods: ["POST"])]
    public function createApartment(
        Request $request,
        UseCaseService $useCaseService
    ): JsonResponse {
        $response = $useCaseService->execute(
            new UseCaseCommand(
                UseCaseEnum::CREATE_APARTMENT,
                $request->toArray()
            )
        );

        return new JsonResponse($response?->toArray(), Response::HTTP_CREATED);
    }

    #[Route(name: "apartments_list", methods: ['GET'])]
    public function getApartmentList(
        Request $request,
        UseCaseService $useCaseService
    ): JsonResponse {
        $response = $useCaseService->execute(
            new UseCaseCommand(
                UseCaseEnum::GET_APARTMENT_LIST,
                $request->query->all()
            )
        );

        return new JsonResponse($response->toArray());
    }
}
