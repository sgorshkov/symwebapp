<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constant\CommonConstants;
use App\Response\ArrayableInterface;

final readonly class PersonWithApartment implements ArrayableInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $lastName,
        public \DateTimeImmutable $birthdate,
        public string $personalIdNumber,
        public string $apartmentNumber,
    ){}

    public static function fromArray(array $params): self
    {
        return new self(
            $params['id'],
            $params['name'],
            $params['last_name'],
            $params['birthdate'],
            $params['personal_id_number'],
            $params['apartment_number']
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->lastName,
            'birth_date' => $this->birthdate->format(CommonConstants::DEFAULT_RESPONSE_DATE_FORMAT),
            'personal_id_number' => $this->personalIdNumber,
            'apartment_number' => $this->apartmentNumber,
        ];
    }
}
