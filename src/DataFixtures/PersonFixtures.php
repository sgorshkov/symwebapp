<?php

namespace App\DataFixtures;

use App\Repository\ApartmentRepository;
use App\Repository\PersonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PersonFixtures extends Fixture implements DependentFixtureInterface
{
    private const int PERSON_PER_APARTMENT = 5;

    public function __construct(
        private readonly ApartmentRepository $apartmentRepository,
        private readonly PersonRepository $personRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $offset = 0;
        $perPage = 100;

        do {
            $apartments = $this->apartmentRepository->createQueryBuilder('a')
                ->getQuery()
                ->setFirstResult($offset)
                ->setMaxResults($perPage)
                ->getResult();
            foreach ($apartments as $apartment) {
                for ($i = 0; $i < self::PERSON_PER_APARTMENT; $i++) {
                    $this->personRepository->createPerson(
                        name: bin2hex(random_bytes(10)),
                        lastName: bin2hex(random_bytes(10)),
                        birthdate: (new \DateTimeImmutable())->modify('-' . $i % 100 . ' years'),
                        personalIdNumber: bin2hex(random_bytes(10)),
                        apartment: $apartment,
                    );
                }
            }

            $manager->flush();
            $manager->clear();
            $offset += $perPage;
        } while ($apartments);
    }

    public function getDependencies(): array
    {
        return [
            HouseFixtures::class,
            ApartmentFixtures::class,
        ];
    }
}
