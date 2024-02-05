<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

final class CommonPersonConstraints
{
    public static function nameConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Length(
                min: 3,
                max: 255,
            ),
        ]);
    }

    public static function lastNameConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Length(
                min: 3,
                max: 255,
            ),
        ]);
    }

    public static function birthdateConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Date(),
        ]);
    }

    public static function personalIdNumberConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Length(
                min: 8,
                max: 50,
            ),
        ]);
    }
}
