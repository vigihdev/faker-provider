<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Providers\Id\Address;

use Faker\Generator;
use Vigihdev\FakerProvider\DTOs\Address\VillageDto;
use Vigihdev\FakerProvider\Enums\ProviderResource;
use Vigihdev\FakerProvider\Providers\AbstractProvider;

final class VillageIdProvider extends AbstractProvider
{

    private VillageDto $dtoVillage;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
        $this->dtoVillage = $this->loadData(ProviderResource::VILLAGE);
    }

    public function village()
    {
        return $this->generator->randomElement($this->dtoVillage->getVillages());
    }
}
