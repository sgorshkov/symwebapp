<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity(repositoryClass: PersonRepository::class)]
#[Table(name: "persons")]
#[UniqueConstraint(name: "unique_personal_id_number", columns: ["personal_id_number"])]
#[UniqueConstraint(name: "unique_person_apartment", columns: ["personal_id_number", "apartment_id"])]
class Person
{
    #[Id, Column, GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    #[Column(length: 255)]
    private ?string $name;

    #[Column(length: 255)]
    private ?string $lastName;

    #[Column(type: "datetime_immutable")]
    private ?\DateTimeInterface $birthdate;

    #[Column(length: 50)]
    private ?string $personalIdNumber;

    #[ManyToOne(targetEntity: Apartment::class)]
    private ?Apartment $apartment;

    public function __construct(
        string $name,
        string $lastName,
        \DateTimeInterface $birthdate,
        string $personalIdNumber,
        Apartment $apartment
    ) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->personalIdNumber = $personalIdNumber;
        $this->apartment = $apartment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function getPersonalIdNumber(): ?string
    {
        return $this->personalIdNumber;
    }

    public function setPersonalIdNumber(string $personalIdNumber): void
    {
        $this->personalIdNumber = $personalIdNumber;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(Apartment $apartment): void
    {
        $this->apartment = $apartment;
    }
}
