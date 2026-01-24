<?php

declare(strict_types=1);

namespace Vigihdev\Faker;

use Serializer\Factory\JsonTransformerFactory;
use Vigihdev\Faker\Contracts\DtoTransformerInterface;
use Vigihdev\Faker\Enums\ProviderResource;
use Vigihdev\Faker\Exceptions\FakerException;

final class DtoTransformer implements DtoTransformerInterface
{

    public function __construct(
        private readonly string $filepath,
        private readonly string $dtoClass
    ) {}

    public function toDto(): object
    {
        return self::fromJsonFile($this->filepath, $this->dtoClass);
    }

    public function getDtoClass(): string
    {
        return $this->dtoClass;
    }

    public function getFilePath(): string
    {
        return $this->filepath;
    }

    public static function fromProviderResource(ProviderResource $resource): object|array
    {

        try {
            return self::fromJsonFile($resource->getPath(), $resource->getDtoClass());
        } catch (\Throwable $e) {
            throw FakerException::handleThrowable($e);
        }
    }

    public static function fromJsonFile(string $filepath, string $dtoClass): object|array
    {
        try {
            $transformer = JsonTransformerFactory::create($dtoClass);
            return $transformer->transformWithFile($filepath);
        } catch (\Throwable $e) {
            throw FakerException::handleThrowable($e);
        }
    }

    public static function fromJsonString(string $json, string $dtoClass): object|array
    {
        try {
            $transformer = JsonTransformerFactory::create($dtoClass);
            $json = trim($json);
            if (substr($json, 0, 1) === '[') {
                return $transformer->transformArrayJson($json);
            }
            return $transformer->transformJson($json);
        } catch (\Throwable $e) {
            throw FakerException::handleThrowable($e);
        }
    }
}
