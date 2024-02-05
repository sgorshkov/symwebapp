<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\GetApartmentsList;

use App\Dto\ApartmentListQueryFilter;
use App\Dto\ApartmentWithPersons;
use App\Entity\Apartment;
use App\Enum\UseCaseEnum;
use App\Repository\ApartmentRepository;
use App\Repository\PersonRepository;
use App\UseCase\UseCaseInterface;

class GetApartmentsListUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly ApartmentRepository $apartmentRepository,
        private readonly PersonRepository $personRepository
    ) {
    }

    #[\Override]
    public function execute(GetApartmentsListRequest $request = null): GetApartmentsListResponse
    {
        $filter = ApartmentListQueryFilter::fromRequest($request);
        $apartments = $this->apartmentRepository->findFilteredPaginated(
            filter: $filter,
            page: $request->page,
            perPage: $request->perPage,
        );
        $housesIds = array_values(array_unique(array_map(fn(Apartment $a) => $a->getHouse()->getId(), $apartments)));
        $persons = $this->personRepository->findAllFromHouses($housesIds);
        $personsByHouse = array_reduce(
            $persons,
            function (array $acc, array $person) {
                $acc[$person['house_id']][] = $person;

                return $acc;
            },
            []
        );
        $apartmentsWithPersonsByHouse = array_map(function (Apartment $a) use ($personsByHouse) {
            return [
                'id' => $a->getId(),
                'number' => $a->getNumber(),
                'persons' => $personsByHouse[$a->getHouse()->getId()],
            ];
        }, $apartments);
        $apartmentsCount = $this->apartmentRepository->countFiltered($filter);

        return new GetApartmentsListResponse(
            items: array_map(fn(array $p) => ApartmentWithPersons::fromArray($p), $apartmentsWithPersonsByHouse),
            page: $request->page,
            perPage: $request->perPage,
            totalPages: (int)ceil($apartmentsCount / $request->perPage),
        );
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::GET_APARTMENT_LIST;
    }
}
