<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\ApartmentListQueryFilter;
use App\Entity\Apartment;
use App\Entity\House;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }

    public function createApartment(string $number, House $house): Apartment
    {
        $apartment = new Apartment(number: $number, house: $house);
        $this->getEntityManager()->persist($apartment);

        return $apartment;
    }

    public function findFilteredPaginated(
        ApartmentListQueryFilter $filter,
        int $page,
        int $perPage
    ) {
        $query = $this
            ->findFilteredQuery($filter)
            ->groupBy('a.id')
            ->orderBy('a.id')
            ->select('a');

        return $query
            ->getQuery()
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->getResult();
    }

    public function countFiltered(ApartmentListQueryFilter $filter): int
    {
        try {
            $count = $this
                ->findFilteredQuery($filter)
                ->select('COUNT(a.id)')
                ->getQuery()->getSingleScalarResult();
        } catch (NoResultException) {
            $count = 0;
        }

        return (int)$count;
    }

    private function findFilteredQuery(ApartmentListQueryFilter $filter): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.house', 'h')
            ->leftJoin('a.persons', 'p');

        if ($filter->houseStreetName) {
            $query
                ->andWhere('h.streetName LIKE :streetName')
                ->setParameter('streetName', '%' . $filter->houseStreetName . '%');
        }

        if ($filter->apartmentNumber) {
            $query
                ->andWhere('a.number=:number')
                ->setParameter('number', $filter->apartmentNumber);
        }

        if ($filter->personName) {
            $query
                ->andWhere('p.name LIKE :personName')
                ->setParameter('personName', '%' . $filter->personName . '%');
        }

        if ($filter->personLastName) {
            $query
                ->andWhere('p.lastName LIKE :personLastName')
                ->setParameter('personLastName', '%' . $filter->personLastName . '%');
        }

        return $query;
    }
}
