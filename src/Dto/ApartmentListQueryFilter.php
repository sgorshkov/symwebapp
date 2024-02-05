<?php

declare(strict_types=1);

namespace App\Dto;

use App\UseCase\Apartment\GetApartmentsList\GetApartmentsListRequest;

final readonly class ApartmentListQueryFilter
{
    public function __construct(
        public ?string $apartmentNumber,
        public ?string $houseStreetName,
        public ?string $personName,
        public ?string $personLastName
    ) {
    }

    public static function fromRequest(GetApartmentsListRequest $request): self
    {
        return new self(
            apartmentNumber: $request->apartmentNumber,
            houseStreetName: $request->houseStreetName,
            personName: $request->personName,
            personLastName: $request->personLastName,
        );
    }
}
