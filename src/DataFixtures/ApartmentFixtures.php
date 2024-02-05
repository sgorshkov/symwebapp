<?php

namespace App\DataFixtures;

use App\Repository\ApartmentRepository;
use App\Repository\HouseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ApartmentFixtures extends Fixture implements DependentFixtureInterface
{
    private const int APARTMENT_PER_HOUSE = 10;

    public function __construct(
        private readonly HouseRepository $houseRepository,
        private readonly ApartmentRepository $apartmentRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $letters = range('a', 'j');
        $offset = 0;
        $perPage = 100;

        do {
            $houses = $this->houseRepository->createQueryBuilder('h')
                ->getQuery()
                ->setFirstResult($offset)
                ->setMaxResults($perPage)
                ->getResult();
            foreach ($houses as $house) {
                for ($i = 0; $i < self::APARTMENT_PER_HOUSE; $i++) {
                    $number = $i % 100;
                    $letter = $letters[$number % 10];
                    $apartmentNumber = $number . $letter;

                    $this->apartmentRepository->createApartment($apartmentNumber, $house);
                }
            }

            $manager->flush();
            $manager->clear();
            $offset += $perPage;
        } while ($houses);
    }

    public function getDependencies(): array
    {
        return [
            HouseFixtures::class,
        ];
    }
}
