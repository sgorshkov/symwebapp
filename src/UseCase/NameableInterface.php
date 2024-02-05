<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Enum\UseCaseEnum;

interface NameableInterface
{
    public function getName(): UseCaseEnum;
}
