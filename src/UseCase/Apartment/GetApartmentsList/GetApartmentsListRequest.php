<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\GetApartmentsList;

final readonly class GetApartmentsListRequest
{
    public function __construct(
        public int $page,
        public int $perPage,
        public ?string $apartmentNumber,
        public ?string $houseStreetName,
        public ?string $personName,
        public ?string $personLastName
    ) {
    }
}
