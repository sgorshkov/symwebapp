<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

final class CommonApartmentConstraints
{
    public static function apartmentIdConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('int'),
            new Positive(),
            new Range(max: PHP_INT_MAX),
        ]);
    }

    public static function apartmentNumberConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Length(
                min: 1,
                max: 50,
            ),
        ]);
    }
}
