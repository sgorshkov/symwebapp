<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Enum\UseCaseEnum;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class UseCaseFactory
{
    private array $useCases;

    public function __construct(
        #[TaggedIterator('use_case_interface')]
        iterable $useCases
    ) {
        foreach ($useCases as $useCase) {
            $this->useCases[$useCase->getName()->name] = $useCase;
        }
    }

    public function getUseCase(UseCaseEnum $name)
    {
        return $this->useCases[$name->name] ?? null;
    }
}
