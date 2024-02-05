<?php

declare(strict_types=1);

namespace App\UseCase\Person\CreatePerson;

use App\Enum\UseCaseEnum;
use App\Repository\PersonRepository;
use App\Service\AppEntityManagerInterface;
use App\UseCase\UseCaseInterface;

class CreatePersonUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly PersonRepository $personRepository,
        private readonly AppEntityManagerInterface $appEntityManager
    ) {
    }

    #[\Override]
    public function execute(CreatePersonRequest $request = null): CreatePersonResponse
    {
        $person = $this->personRepository->createPerson(
            name: $request->name,
            lastName: $request->lastName,
            birthdate: $request->birthdate,
            personalIdNumber: $request->personalIdNumber,
            apartment: $request->apartment,
        );
        $this->appEntityManager->flush();

        return new CreatePersonResponse($person->getId());
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_PERSON;
    }
}
