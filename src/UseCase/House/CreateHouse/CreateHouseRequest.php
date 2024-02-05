<?php

declare(strict_types=1);

namespace App\UseCase\House\CreateHouse;

final readonly class CreateHouseRequest
{
    public function __construct(
        public string $number,
        public string $streetName
    ) {
    }
}
