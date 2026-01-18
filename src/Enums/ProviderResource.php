<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Enums;

use Vigihdev\FakerProvider\DTOs\Address\{ProvinceDto, VillageDto};

enum ProviderResource: string
{
    case PROVINCE = 'address/province';
    case VILLAGE = 'address/village';

    public function getDtoClass(): string
    {
        return match ($this) {
            self::VILLAGE => VillageDto::class,
            self::PROVINCE => ProvinceDto::class,
        };
    }

    public function getPath(): string
    {
        return "{$this->value}.json";
    }
}
