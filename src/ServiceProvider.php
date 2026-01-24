<?php

declare(strict_types=1);

namespace Vigihdev\Faker;

use Vigihdev\Faker\Contracts\{DtoTransformerInterface, ProviderInterface, ServiceProviderInterface};

final class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var DtoTransformerInterface[]
     */
    private array $providers = [];

    /**
     * @param DtoTransformerInterface[] $providers
     */
    public function __construct(iterable $providers)
    {
        if (is_array($providers)) {
            $this->providers = $providers;
            return;
        }

        if ($providers instanceof \Traversable) {
            $this->providers = iterator_to_array($providers);
        }
    }

    public function hasProvider(string $providerClass): bool
    {
        return in_array($providerClass, $this->getAvailableProviderClasses(), true);
    }

    public function getAvailableProviderClasses(): array
    {
        return array_map(fn(ProviderInterface $provider) => get_class($provider), $this->providers);
    }

    public function getProvider(string $providerClass): ?ProviderInterface
    {
        foreach ($this->providers as $provider) {
            /** @var ProviderInterface $provider */
            $class = get_class($provider);
            if ($class === $providerClass) {
                return $provider;
            }
        }
        return null;
    }
}
