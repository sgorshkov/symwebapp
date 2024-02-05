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

#[Route("/houses")]
final class HouseController
{
    #[Route(name: "house_create", methods: ["POST"])]
    public function createHouse(
        Request $request,
        UseCaseService $useCaseService
    ): JsonResponse {
        $response = $useCaseService->execute(
            new UseCaseCommand(
                UseCaseEnum::CREATE_HOUSE, $request->toArray()
            )
        );

        return new JsonResponse($response->toArray(), Response::HTTP_CREATED);
    }
}
