<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\CreateApartment;

use App\UseCase\UseCaseResponseInterface;

final readonly class CreateApartmentResponse implements UseCaseResponseInterface
{
    public function __construct(public int $id)
    {
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
