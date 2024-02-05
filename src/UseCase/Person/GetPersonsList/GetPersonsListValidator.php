<?php

declare(strict_types=1);

namespace App\UseCase\Person\GetPersonsList;

use App\Constant\PaginationConstants;
use App\Enum\UseCaseEnum;
use App\Exception\ValidationException;
use App\UseCase\UseCaseValidatorInterface;
use App\Validator\CommonApartmentConstraints;
use App\Validator\CommonHouseConstraints;
use App\Validator\CommonPaginationConstraints;
use App\Validator\CommonPersonConstraints;
use App\Validator\ValidatorTrait;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;

class GetPersonsListValidator implements UseCaseValidatorInterface
{
    use ValidatorTrait;

    #[\Override]
    public function validateAndMap(array $params): GetPersonsListRequest
    {
        $this->validateArrayData(
            $params,
            new Collection([
                'page' => new Optional(CommonPaginationConstraints::pageConstraint()),
                'per_page' => new Optional(CommonPaginationConstraints::perPageConstraint()),
                'name' => new Optional(CommonPersonConstraints::nameConstraint()),
                'last_name' => new Optional(CommonPersonConstraints::lastNameConstraint()),
                'birthdate_from' => new Optional(CommonPersonConstraints::birthdateConstraint()),
                'birthdate_to' => new Optional(CommonPersonConstraints::birthdateConstraint()),
                'personal_id_number' => new Optional(CommonPersonConstraints::personalIdNumberConstraint()),
                'apartment_number' => new Optional(CommonApartmentConstraints::apartmentNumberConstraint()),
                'house_number' => new Optional(CommonHouseConstraints::houseNumberConstraint()),
                'house_street_name' => new Optional(CommonHouseConstraints::houseStreetNameConstraint()),
            ]),
        );

        $birthdateFrom = null;
        if ($params['birthdate_from'] ?? null) {
            $birthdateFrom = new \DateTimeImmutable($params['birthdate_from']);
        }
        $birthdateTo = null;
        if ($params['birthdate_to'] ?? null) {
            $birthdateTo = new \DateTimeImmutable($params['birthdate_to']);
        }
        if ($birthdateFrom && $birthdateTo && $birthdateTo < $birthdateFrom) {

            throw ValidationException::fromArray(['[birthday_to]' => 'birthday_to can not be less than birthday_from']);
        }

        return new GetPersonsListRequest(
            page: $params['page'] ?? null ? (int)$params['page'] : 1,
            perPage: $params['per_page'] ?? null ? (int)$params['per_page'] : PaginationConstants::DEFAULT_PER_PAGE,
            name: $params['name'] ?? null,
            lastName: $params['last_name'] ?? null,
            birthdateFrom: $birthdateFrom,
            birthdateTo: $birthdateTo,
            personalIdNumber: $params['personal_id_number'] ?? null,
            apartmentNumber: $params['apartment_number'] ?? null,
            houseNumber: $params['house_number'] ?? null,
            houseStreetName: $params['house_street_name'] ?? null,
        );
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::GET_PERSONS_LIST;
    }
}
