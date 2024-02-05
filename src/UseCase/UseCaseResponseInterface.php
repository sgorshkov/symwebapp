<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Response\ArrayableInterface;

interface UseCaseResponseInterface extends \JsonSerializable, ArrayableInterface
{
}
