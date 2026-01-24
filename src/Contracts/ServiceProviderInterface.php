<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;


interface ServiceProviderInterface
{

    public function hasProvider(string $providerClass): bool;

    /**
     * @return string[]
     */
    public function getAvailableProviderClasses(): array;

    public function getProvider(string $providerClass): ?ProviderInterface;
}
