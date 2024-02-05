<?php

declare(strict_types=1);

namespace App\Service;

use App\UseCase\UseCaseCommand;
use App\UseCase\UseCaseFactory;
use App\UseCase\UseCaseResponseInterface;
use App\UseCase\UseCaseValidatorFactory;

final readonly class UseCaseService
{
    public function __construct(
        private UseCaseFactory $useCaseFactory,
        private UseCaseValidatorFactory $useCaseValidatorFactory
    ) {
    }

    public function execute(UseCaseCommand $useCaseCommand): ?UseCaseResponseInterface
    {
        $useCase = $this->useCaseFactory->getUseCase($useCaseCommand->name);

        $request = null;
        if (null !== $useCaseCommand->params) {
            $validator = $this->useCaseValidatorFactory->getUseCaseValidator($useCaseCommand->name);
            $request = $validator->validateAndMap($useCaseCommand->params);
        }

        return $useCase->execute($request);
    }
}
