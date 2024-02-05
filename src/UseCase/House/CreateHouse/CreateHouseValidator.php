<?php

declare(strict_types=1);

namespace App\UseCase\House\CreateHouse;

use App\Enum\UseCaseEnum;
use App\UseCase\UseCaseValidatorInterface;
use App\Validator\CommonHouseConstraints;
use App\Validator\ValidatorTrait;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;

class CreateHouseValidator implements UseCaseValidatorInterface
{
    use ValidatorTrait;

    #[\Override]
    public function validateAndMap(array $params): CreateHouseRequest
    {
        $this->validateArrayData(
            $params,
            new Collection([
                'number' => new Required(CommonHouseConstraints::houseNumberConstraint()),
                'street_name' => new Required(CommonHouseConstraints::houseStreetNameConstraint()),
            ])
        );

        return new CreateHouseRequest($params['number'], $params['street_name']);
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::CREATE_HOUSE;
    }
}
