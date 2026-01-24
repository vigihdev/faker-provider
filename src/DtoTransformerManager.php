<?php

declare(strict_types=1);

namespace Vigihdev\Faker;

use Vigihdev\Faker\Contracts\{DtoTransformerInterface, DtoTransformerManagerInterface};

final class DtoTransformerManager implements DtoTransformerManagerInterface
{

    /**
     * @var DtoTransformerInterface[]
     */
    private array $dtos = [];

    /**
     * @param DtoTransformerInterface[] $dtos
     */
    public function __construct(iterable $dtos)
    {
        if (is_array($dtos)) {
            $this->dtos = $dtos;
            return;
        }

        if ($dtos instanceof \Traversable) {
            $this->dtos = iterator_to_array($dtos);
        }
    }

    public function hasTransformerFor(string $dtoClass): bool
    {
        return in_array($dtoClass, $this->getAvailableDtoClasses(), true);
    }

    public function getTransformer(string $dtoClass): ?DtoTransformerInterface
    {
        foreach ($this->dtos as $dto) {
            if ($dto->getDtoClass() === $dtoClass) {
                return $dto;
            }
        }
        return null;
    }

    public function getAvailableDtoClasses(): array
    {
        return array_map(fn(DtoTransformerInterface $dto) => $dto->getDtoClass(), $this->dtos);
    }

    public function getDto(string $dtoClass): ?object
    {
        $transformer = $this->getTransformer($dtoClass);
        if ($transformer === null) {
            return null;
        }
        return $transformer->toDto();
    }
}
