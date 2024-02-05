<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constant\CommonConstants;
use App\Response\ArrayableInterface;

final readonly class PersonWithAddress implements ArrayableInterface
{
    public function __construct(
        public int $personId,
        public string $name,
        public string $lastName,
        public \DateTimeImmutable $birthdate,
        public string $personalIdNumber,
        public string $houseNumber,
        public string $apartmentNumber,
        public string $streetName
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            $params['person_id'],
            $params['name'],
            $params['last_name'],
            $params['birthdate'],
            $params['personal_id_number'],
            $params['house_number'],
            $params['apartment_number'],
            $params['street_name'],
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'person_id' => $this->personId,
            'name' => $this->name,
            'last_name' => $this->lastName,
            'birth_date' => $this->birthdate->format(CommonConstants::DEFAULT_RESPONSE_DATE_FORMAT),
            'personal_id_number' => $this->personalIdNumber,
            'house_number' => $this->houseNumber,
            'apartment_number' => $this->apartmentNumber,
            'street_name' => $this->streetName,
        ];
    }
}
