<?php

declare(strict_types=1);

namespace App\Service;

interface AppEntityManagerInterface
{
    public function persist(object $object): void;

    public function flush(): void;
}
