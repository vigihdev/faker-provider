<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Contracts\Dto;

interface AddressDtoInterface
{

    public function getCities(): array;
    public function getProvinces(): array;
    public function getStreets(): array;
    public function getNeighborhoods(): array;
}
