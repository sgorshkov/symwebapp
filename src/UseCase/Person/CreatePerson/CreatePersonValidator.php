<?php

declare(strict_types=1);

namespace App\UseCase\Person\CreatePerson;

use App\Enum\UseCaseEnum;
use App\Exception\ValidationException;
use App\Repository\ApartmentRepository;
use App\UseCase\UseCaseValidatorInterface;
use App\Validator\CommonApartmentConstraints;
use App\Validator\CommonPersonConstraints;
use App\Validator\ValidatorTrait;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;

class CreatePersonValidator implements UseCaseValidatorInterface
{
    use ValidatorTrait;

    public function __construct(
        private readonly ApartmentRepository $apartmentRepository
    ) {
    }

    #[\Override]
    public function validateAndMap(array $params): CreatePersonRequest
    {
        $this->validateArrayData(
            $params,
            new Collection([
                'name' => new Required(CommonPersonConstraints::nameConstraint()),
                'last_name' => new Required(CommonPersonConstraints::lastNameConstraint()),
                'birthdate' => new Required(CommonPersonConstraints::birthdateConstraint()),
                'personal_id_number' => new Required(CommonPersonConstraints::personalIdNumberConstraint()),
                'apartment_id' => new Required(CommonApartmentConstraints::apartmentIdConstraint()),
            ])
        );

        $apartment = $this->apartmentRepository->find($params['apartment_id']);
        if (!$apartment) {
            throw ValidationException::fromArray(['[apartment_id]' => 'apartment not found']);
        }

        return new CreatePersonRequest(
            name: $params['name'],
            lastName: $params['last_name'],
            birthdate: new \DateTimeImmutable($params['birthdate']),
            personalIdNumber: $params['personal_id_number'],
            apartment: $apartment,
        );
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_PERSON;
    }
}
