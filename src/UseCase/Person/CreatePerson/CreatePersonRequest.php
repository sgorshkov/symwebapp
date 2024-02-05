<?php

declare(strict_types=1);

namespace App\UseCase\Person\CreatePerson;

use App\Entity\Apartment;
use App\UseCase\UseCaseRequestInterface;

final readonly class CreatePersonRequest implements UseCaseRequestInterface
{
    public function __construct(
        public string $name,
        public string $lastName,
        public \DateTimeInterface $birthdate,
        public string $personalIdNumber,
        public Apartment $apartment
    ) {
    }
}
