<?php

namespace App\DataFixtures;

use App\Repository\HouseRepository;
use App\Util\StringFromPartsGeneratorUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class HouseFixtures extends Fixture
{
    private const int HOUSE_COUNT = 100;
    private const array NAME_PARTS = [
        'blue',
        'yellow',
        'red',
        'gray',
        'carbon',
        'blank',
        'black',
        'green',
        'white',
        'cian',
    ];

    public function __construct(private readonly HouseRepository $houseRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $letters = range('a', 'j');
        for ($i = 0; $i < self::HOUSE_COUNT; $i++) {
            $streetName = StringFromPartsGeneratorUtil::generate($i, self::NAME_PARTS);
            $number = $i % 100;
            $letter = $letters[$number % 10];
            $houseNumber = $number . $letter;

            $this->houseRepository->createHouse($houseNumber, $streetName);

            if ($i % 100 === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        $manager->clear();
    }
}
