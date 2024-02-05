<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Enum\UseCaseEnum;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class UseCaseValidatorFactory
{
    private array $useCaseValidators;

    public function __construct(
        #[TaggedIterator('use_case_validator_interface')]
        iterable $useCaseValidators
    ) {
        foreach ($useCaseValidators as $useCaseValidator) {
            $this->useCaseValidators[$useCaseValidator->getName()->name] = $useCaseValidator;
        }
    }

    public function getUseCaseValidator(UseCaseEnum $name)
    {
        return $this->useCaseValidators[$name->name] ?? null;
    }
}
