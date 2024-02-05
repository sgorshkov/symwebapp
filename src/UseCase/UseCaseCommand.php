<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Enum\UseCaseEnum;

final readonly class UseCaseCommand
{
    public function __construct(
        public UseCaseEnum $name,
        public ?array $params = null
    ) {
    }
}
