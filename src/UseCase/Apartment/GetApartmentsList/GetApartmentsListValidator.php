<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\GetApartmentsList;

use App\Constant\PaginationConstants;
use App\Enum\UseCaseEnum;
use App\UseCase\UseCaseValidatorInterface;
use App\Validator\CommonApartmentConstraints;
use App\Validator\CommonHouseConstraints;
use App\Validator\CommonPaginationConstraints;
use App\Validator\CommonPersonConstraints;
use App\Validator\ValidatorTrait;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;

class GetApartmentsListValidator implements UseCaseValidatorInterface
{
    use ValidatorTrait;

    #[\Override]
    public function validateAndMap(array $params): GetApartmentsListRequest
    {
        $this->validateArrayData(
            $params,
            new Collection([
                'page' => new Optional(CommonPaginationConstraints::pageConstraint()),
                'per_page' => new Optional(CommonPaginationConstraints::perPageConstraint()),
                'apartment_number' => new Optional(CommonApartmentConstraints::apartmentNumberConstraint()),
                'house_street_name' => new Optional(CommonHouseConstraints::houseStreetNameConstraint()),
                'person_name' => new Optional(CommonPersonConstraints::nameConstraint()),
                'person_last_name' => new Optional(CommonPersonConstraints::lastNameConstraint()),
            ])
        );

        return new GetApartmentsListRequest(
            page: $params['page'] ?? null ? (int)$params['page'] : 1,
            perPage: $params['per_page'] ?? null ? (int)$params['per_page'] : PaginationConstants::DEFAULT_PER_PAGE,
            apartmentNumber: $params['apartment_number'] ?? null,
            houseStreetName: $params['house_street_name'] ?? null,
            personName: $params['person_name'] ?? null,
            personLastName: $params['person_last_name'] ?? null,
        );
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::GET_APARTMENT_LIST;
    }
}
