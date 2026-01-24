<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;

interface ItemsAbleInterface
{
    public function getItems(int $offset = 0, ?int $length = null): array;
}
