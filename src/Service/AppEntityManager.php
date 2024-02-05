<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

final readonly class AppEntityManager implements AppEntityManagerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[\Override]
    public function persist(object $object): void
    {
        $this->entityManager->persist($object);
    }

    #[\Override]
    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
