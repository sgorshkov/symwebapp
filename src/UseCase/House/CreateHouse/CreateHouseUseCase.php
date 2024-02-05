<?php

declare(strict_types=1);

namespace App\UseCase\House\CreateHouse;

use App\Enum\UseCaseEnum;
use App\Repository\HouseRepository;
use App\Service\AppEntityManagerInterface;
use App\UseCase\UseCaseInterface;

class CreateHouseUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly HouseRepository $houseRepository,
        private readonly AppEntityManagerInterface $entityManager
    ) {
    }

    #[\Override]
    public function execute(CreateHouseRequest $request = null): CreateHouseResponse
    {
        $house = $this->houseRepository->createHouse($request->number, $request->streetName);
        $this->entityManager->flush();

        return new CreateHouseResponse($house->getId());
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_HOUSE;
    }
}
