<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;

interface DtoTransformerManagerInterface
{
    public function hasTransformerFor(string $dtoClass): bool;

    public function getTransformer(string $dtoClass): ?DtoTransformerInterface;

    public function getAvailableDtoClasses(): array;

    public function getDto(string $dtoClass): ?object;
}
