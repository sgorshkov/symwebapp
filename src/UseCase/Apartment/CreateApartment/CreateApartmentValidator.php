<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\CreateApartment;

use App\Enum\UseCaseEnum;
use App\Exception\ValidationException;
use App\Repository\HouseRepository;
use App\UseCase\UseCaseValidatorInterface;
use App\Validator\CommonApartmentConstraints;
use App\Validator\CommonHouseConstraints;
use App\Validator\ValidatorTrait;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;

class CreateApartmentValidator implements UseCaseValidatorInterface
{
    use ValidatorTrait;

    public function __construct(private readonly HouseRepository $houseRepository)
    {
    }

    #[\Override]
    public function validateAndMap(array $params): CreateApartmentRequest
    {
        $this->validateArrayData(
            $params,
            new Collection([
                'number' => new Required(CommonApartmentConstraints::apartmentNumberConstraint()),
                'house_id' => new Required(CommonHouseConstraints::houseIdConstraint()),
            ])
        );

        $house = $this->houseRepository->find($params['house_id']);
        if (!$house) {
            throw ValidationException::fromArray(['[house_id]' => 'house not found']);
        }

        return new CreateApartmentRequest($params['number'], $house);
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_APARTMENT;
    }
}
