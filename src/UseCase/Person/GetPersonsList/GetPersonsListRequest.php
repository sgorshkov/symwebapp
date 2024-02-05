<?php

declare(strict_types=1);

namespace App\UseCase\Person\GetPersonsList;

class GetPersonsListRequest
{
    public function __construct(
        public int $page,
        public int $perPage,
        public ?string $name = null,
        public ?string $lastName = null,
        public ?\DateTimeImmutable $birthdateFrom = null,
        public ?\DateTimeImmutable $birthdateTo = null,
        public ?string $personalIdNumber = null,
        public ?string $apartmentNumber = null,
        public ?string $houseNumber = null,
        public ?string $houseStreetName = null,
    ) {
    }
}
