<?php

declare(strict_types=1);

namespace Vigihdev\Faker\DTOs;

use Vigihdev\Faker\Contracts\RegionDtoInterface;

final class RegionDto implements RegionDtoInterface
{
    public function __construct(
        private readonly array $routes = [],
    ) {}

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
