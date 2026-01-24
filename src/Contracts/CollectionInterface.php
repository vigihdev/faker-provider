<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;

use Vigihdev\Support\Collection;

interface CollectionInterface
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function generate(int $length = 1): Collection;
}
