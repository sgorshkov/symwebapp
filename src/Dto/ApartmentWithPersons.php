<?php

declare(strict_types=1);

namespace App\Dto;

use App\Response\ArrayableInterface;

final readonly class ApartmentWithPersons implements ArrayableInterface
{
    /**
     * @param int $id
     * @param string $number
     * @param PersonWithApartment[] $persons
     */
    public function __construct(
        public int $id,
        public string $number,
        public array $persons = []
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            $params['id'],
            $params['number'],
            array_map(fn(array $p) => PersonWithApartment::fromArray($p), $params['persons']),
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'persons' => array_map(fn(PersonWithApartment $p) => $p->toArray(), $this->persons),
        ];
    }
}
