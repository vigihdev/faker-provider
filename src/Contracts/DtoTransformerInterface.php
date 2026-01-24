<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;

interface DtoTransformerInterface
{

    public function toDto(): object;

    public function getDtoClass(): string;

    public function getFilePath(): string;
}
