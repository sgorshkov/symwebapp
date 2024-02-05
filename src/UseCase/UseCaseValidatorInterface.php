<?php

declare(strict_types=1);

namespace App\UseCase;

interface UseCaseValidatorInterface extends NameableInterface
{
    public function validateAndMap(array $params);
}
