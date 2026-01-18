<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Providers\Id\Address;

use Faker\Generator;
use Vigihdev\FakerProvider\DTOs\Address\ProvinceDto;
use Vigihdev\FakerProvider\Enums\ProviderResource;
use Vigihdev\FakerProvider\Providers\AbstractProvider;

final class ProvinceIdProvider extends AbstractProvider
{

    private ProvinceDto $dtoProvince;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
        $this->dtoProvince = $this->loadData(ProviderResource::PROVINCE);
    }

    public function province()
    {
        return $this->generator->randomElement($this->dtoProvince->getProvinces());
    }
}
