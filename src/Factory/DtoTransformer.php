<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Factory;

use Serializer\Factory\JsonTransformerFactory;
use Symfony\Component\Filesystem\Path;
use Vigihdev\FakerProvider\Exceptions\FakerProviderException;
use Vigihdev\FakerProvider\Validators\FakerProviderValidator;

final class DtoTransformer
{

    public static function fromJsonFile(string $filepath, string $dtoClass): object|array
    {
        try {

            $filepath = Path::isAbsolute($filepath) ? $filepath : Path::join(getcwd(), $filepath);
            FakerProviderValidator::validate($filepath)
                ->mustExistFile()
                ->mustBeReadable()
                ->mustBeExtensionJson();

            $transformer = JsonTransformerFactory::create($dtoClass);
            return $transformer->transformWithFile($filepath);
        } catch (\Throwable $e) {
            throw new FakerProviderException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
