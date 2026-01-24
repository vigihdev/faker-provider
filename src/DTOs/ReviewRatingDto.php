<?php

declare(strict_types=1);

namespace Vigihdev\Faker\DTOs;

use Vigihdev\Faker\Contracts\ReviewRatingDtoInterface;

final class ReviewRatingDto implements ReviewRatingDtoInterface
{
    public function __construct(
        private readonly array $items,
    ) {}

    public function getItems(int $offset = 0, ?int $length = null): array
    {
        return array_slice($this->items, $offset, $length);
    }
}
