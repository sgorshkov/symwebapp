<?php

declare(strict_types=1);

namespace App\UseCase;

interface UseCaseInterface extends NameableInterface
{
    public function execute(): UseCaseResponseInterface;
}
