<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Provider;

use Faker\Generator;
use Vigihdev\Faker\Contracts\DtoTransformerManagerInterface;
use Vigihdev\Faker\Contracts\ProviderInterface;
use VigihDev\SymfonyBridge\Config\Service\ServiceLocator;

abstract class AbstractProvider implements ProviderInterface
{

    protected ?DtoTransformerManagerInterface $dtoTransformer = null;

    public function __construct(
        protected Generator $faker,
        ?DtoTransformerManagerInterface $dtoTransformer = null,
    ) {

        if ($dtoTransformer === null) {
            if (ServiceLocator::has(DtoTransformerManagerInterface::class)) {
                $this->dtoTransformer = ServiceLocator::get(DtoTransformerManagerInterface::class);
            }
        }
    }

    protected function price(): int
    {
        $start = 250000;
        $prices = [];
        for ($i = 0; $i < 10; $i++) {
            $price = $start + ($i * 25000);
            $prices[] = $price;
        }
        return $this->faker->randomElement($prices);
    }
}
