<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity(repositoryClass: ApartmentRepository::class)]
#[Table(name: "apartments")]
#[UniqueConstraint(name: "unique_apartment_house", columns: ["number", "house_id"])]
class Apartment
{
    #[Id, Column, GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    #[Column(length: 50)]
    private ?string $number;

    #[ManyToOne(targetEntity: House::class)]
    private ?House $house;

    #[OneToMany(mappedBy: 'apartment', targetEntity: Person::class)]
    private Collection $persons;

    public function __construct(string $number, House $house)
    {
        $this->number = $number;
        $this->house = $house;
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

    public function getHouse(): House
    {
        return $this->house;
    }

    public function setHouse(House $house): void
    {
        $this->house = $house;
    }

    public function getPersons(): array
    {
        return $this->persons->toArray();
    }
}
