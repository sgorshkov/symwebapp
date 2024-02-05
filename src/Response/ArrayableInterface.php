<?php

declare(strict_types=1);

namespace App\Response;

interface ArrayableInterface
{
    public function toArray(): array;
}
