<?php

declare(strict_types=1);

namespace App\UseCase\Person\GetPersonsList;

use App\Dto\PersonsListQueryFilter;
use App\Dto\PersonWithAddress;
use App\Enum\UseCaseEnum;
use App\Repository\PersonRepository;
use App\UseCase\UseCaseInterface;

class GetPersonsListUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly PersonRepository $personRepository
    ) {
    }

    public function execute(GetPersonsListRequest $request = null): GetPersonsListResponse
    {
        $filter = PersonsListQueryFilter::fromRequest($request);
        $persons = $this->personRepository->findFilteredPaginated(
            $filter,
            $request->page,
            $request->perPage
        );
        $personsCount = $this->personRepository->countFiltered($filter);

        return new GetPersonsListResponse(
            items: array_map(fn(array $p) => PersonWithAddress::fromArray($p), $persons),
            page: $request->page,
            perPage: $request->perPage,
            totalPages: (int)ceil($personsCount / $request->perPage),
        );
    }

    #[\Override]
    public function getName(): UseCaseEnum
    {
        return UseCaseEnum::GET_PERSONS_LIST;
    }
}
