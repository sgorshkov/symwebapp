<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\CreateApartment;

use App\Enum\UseCaseEnum;
use App\Repository\ApartmentRepository;
use App\Service\AppEntityManagerInterface;
use App\UseCase\UseCaseInterface;
use App\UseCase\UseCaseResponseInterface;

class CreateApartmentUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly ApartmentRepository $apartmentRepository,
        private readonly AppEntityManagerInterface $entityManager
    ) {
    }

    #[\Override]
    public function execute(CreateApartmentRequest $request = null): UseCaseResponseInterface
    {
        $apartment = $this->apartmentRepository->createApartment(
            $request->number,
            $request->house
        );
        $this->entityManager->flush();

        return new CreateApartmentResponse($apartment->getId());
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_APARTMENT;
    }
}
