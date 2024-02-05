<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity(repositoryClass: HouseRepository::class)]
#[Table(name: "houses")]
#[UniqueConstraint(name: "unique_house_address", columns: ["number", "street_name"])]
class House
{
    #[Id, Column, GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    #[Column(length: 100)]
    private ?string $number;

    #[Column(length: 255)]
    private ?string $streetName;

    public function __construct(string $number, string $streetName)
    {
        $this->number = $number;
        $this->streetName = $streetName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): void
    {
        $this->streetName = $streetName;
    }
}
