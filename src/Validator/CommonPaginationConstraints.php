<?php

declare(strict_types=1);

namespace App\Validator;

use App\Constant\PaginationConstants;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

class CommonPaginationConstraints
{
    public static function pageConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Positive(),
        ]);
    }

    public static function perPageConstraint(): Constraint
    {
        return new Sequentially([
            new NotBlank(),
            new Type('string'),
            new Positive(),
            new Range(max: PaginationConstants::MAX_PER_PAGE),
        ]);
    }
}
