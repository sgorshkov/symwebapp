<?php

declare(strict_types=1);

namespace App\UseCase\Apartment\GetApartmentsList;

use App\Response\PaginatedResponse;
use App\UseCase\UseCaseResponseInterface;

final readonly class GetApartmentsListResponse extends PaginatedResponse implements UseCaseResponseInterface
{
}
