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

#[Route("/persons")]
final class PersonController
{
    #[Route(name: "person_create", methods: ["POST"])]
    public function createPerson(
        Request $request,
        UseCaseService $useCaseService
    ): JsonResponse {
        $response = $useCaseService->execute(
            new UseCaseCommand(
                UseCaseEnum::CREATE_PERSON,
                $request->toArray()
            )
        );

        return new JsonResponse($response->toArray(), Response::HTTP_CREATED);
    }

    #[Route(name: "persons_list", methods: ["GET"])]
    public function getPersonsList(
        Request $request,
        UseCaseService $useCaseService
    ): JsonResponse {
        $response = $useCaseService->execute(
            new UseCaseCommand(
                UseCaseEnum::GET_PERSONS_LIST,
                $request->query->all()
            )
        );

        return new JsonResponse($response->toArray());
    }
}
