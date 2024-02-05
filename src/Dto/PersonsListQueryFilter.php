<?php

declare(strict_types=1);

namespace App\Dto;

use App\UseCase\Person\GetPersonsList\GetPersonsListRequest;

final readonly class PersonsListQueryFilter
{
    public function __construct(
        public ?string $name,
        public ?string $lastName,
        public ?\DateTimeImmutable $birthdateFrom,
        public ?\DateTimeImmutable $birthdateTo,
        public ?string $personalIdNumber,
        public ?string $apartmentNumber,
        public ?string $houseNumber,
        public ?string $houseStreetName
    ) {
    }

    public static function fromRequest(GetPersonsListRequest $request): self
    {
        return new self(
            name: $request->name,
            lastName: $request->lastName,
            birthdateFrom: $request->birthdateFrom,
            birthdateTo: $request->birthdateTo,
            personalIdNumber: $request->personalIdNumber,
            apartmentNumber: $request->apartmentNumber,
            houseNumber: $request->houseNumber,
            houseStreetName: $request->houseStreetName,
        );
    }
}
