<?php

declare(strict_types=1);

namespace App\Response;

readonly class PaginatedResponse implements \JsonSerializable, ArrayableInterface
{
    /**
     * @param ArrayableInterface[] $items
     */
    public function __construct(
        public array $items,
        public int $page,
        public int $perPage,
        public int $totalPages
    ) {
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'total_pages' => $this->totalPages,
            'items' => array_map(fn(ArrayableInterface $item) => $item->toArray(), $this->items),
        ];
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
