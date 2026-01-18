<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\DTOs\Address;

final class VillageDto
{

    public function __construct(
        private readonly array $villages,
    ) {}

    public function getVillages(): array
    {
        return $this->villages;
    }
}
