<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\DTOs\Address;

final class ProvinceDto
{

    public function __construct(
        private readonly array $provinces,
    ) {}

    public function getProvinces(): array
    {
        return $this->provinces;
    }
}
