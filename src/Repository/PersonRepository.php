<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\PersonsListQueryFilter;
use App\Entity\Apartment;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function createPerson(
        string $name,
        string $lastName,
        \DateTimeInterface $birthdate,
        string $personalIdNumber,
        Apartment $apartment
    ): Person {
        $person = new Person(
            name: $name,
            lastName: $lastName,
            birthdate: $birthdate,
            personalIdNumber: $personalIdNumber,
            apartment: $apartment,
        );
        $this->getEntityManager()->persist($person);

        return $person;
    }

    public function countFiltered(PersonsListQueryFilter $filter): int
    {
        try {
            $count = $this
                ->findFilteredQuery($filter)
                ->select('COUNT(p.id)')
                ->getQuery()->getSingleScalarResult();
        } catch (NoResultException) {
            $count = 0;
        }

        return (int)$count;
    }

    public function findFilteredPaginated(
        PersonsListQueryFilter $filter,
        int $page,
        int $perPage
    ): array {
        $query = $this
            ->findFilteredQuery($filter)
            ->orderBy('p.id');
        $query->select(
            'p.id AS person_id',
            'p.name',
            'p.lastName AS last_name',
            'p.birthdate',
            'p.personalIdNumber AS personal_id_number',
            'a.number AS apartment_number',
            'h.number AS house_number',
            'h.streetName AS street_name',
        );

        return $query
            ->getQuery()
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->getArrayResult();
    }

    public function findAllFromHouses(array $housesIds)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.apartment', 'a')
            ->leftJoin('a.house', 'h')
            ->select(
                'p.id',
                'p.lastName AS last_name',
                'p.name',
                'p.birthdate',
                'p.personalIdNumber AS personal_id_number',
                'a.number AS apartment_number',
                'h.id AS house_id',
            )
            ->andWhere('h.id IN(:houseIds)')->setParameter('houseIds', $housesIds)
            ->getQuery()->getResult();
    }

    private function findFilteredQuery(
        PersonsListQueryFilter $filter
    ): QueryBuilder {
        $query = $this
            ->createQueryBuilder('p')
            ->leftJoin('p.apartment', 'a')
            ->leftJoin('a.house', 'h');

        if ($filter->name) {
            $query->andWhere('p.name=:name')->setParameter('name', $filter->name);
        }
        if ($filter->lastName) {
            $query
                ->andWhere('p.lastName LIKE :lastName')
                ->setParameter('lastName', '%' . $filter->lastName . '%');
        }
        if ($filter->birthdateFrom) {
            $query
                ->andWhere('p.birthdate>=:birthdateFrom')
                ->setParameter('birthdateFrom', $filter->birthdateFrom);
        }
        if ($filter->birthdateTo) {
            $query
                ->andWhere('p.birthdate>=:birthdateTo')
                ->setParameter('birthdateTo', $filter->birthdateTo);
        }
        if ($filter->personalIdNumber) {
            $query
                ->andWhere('p.personalIdNumber=:personalIdNumber')
                ->setParameter('personalIdNumber', $filter->personalIdNumber);
        }
        if ($filter->personalIdNumber) {
            $query
                ->andWhere('a.number=:apartmentNumber')
                ->setParameter('apartmentNumber', $filter->apartmentNumber);
        }
        if ($filter->houseNumber) {
            $query
                ->andWhere('h.number=:houseNumber')
                ->setParameter('houseNumber', $filter->houseNumber);
        }
        if ($filter->houseStreetName) {
            $query
                ->andWhere('h.streetName LIKE :houseStreetName')
                ->setParameter('houseStreetName', '%' . $filter->houseStreetName . '%');
        }

        return $query;
    }
}
