<?php

declare(strict_types=1);

namespace App\UseCase\Person\GetPersonsList;

use App\Response\PaginatedResponse;
use App\UseCase\UseCaseResponseInterface;

final readonly class GetPersonsListResponse extends PaginatedResponse implements UseCaseResponseInterface
{
}
