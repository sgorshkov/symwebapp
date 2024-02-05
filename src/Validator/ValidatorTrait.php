<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

trait ValidatorTrait
{
    /**
     * @throws ValidationException
     */
    private function validateArrayData(
        array $params,
        Collection $constraints
    ): void {
        $errors = Validation::createValidator()->validate($params, $constraints);
        if (0 !== count($errors)) {
            throw ValidationException::fromViolationArray($errors);
        }
    }
}
