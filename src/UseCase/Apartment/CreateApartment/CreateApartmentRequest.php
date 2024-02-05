<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\CreateApartment;

use App\Entity\House;

final readonly class CreateApartmentRequest
{
    public function __construct(
        public string $number,
        public House $house
    ) {
    }
}
