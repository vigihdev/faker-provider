<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Exceptions;

class FakerProviderException extends \Exception
{

    public static function filepathNotFound(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Found: %s", $filepath)
        );
    }

    public static function filepathNotReadable(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Readable: %s", $filepath)
        );
    }

    public static function filepathNotWritable(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Writable: %s", $filepath)
        );
    }

    public static function filepathInvalidExtensionJson(string $filepath, string $ext): self
    {
        return new self(
            message: sprintf("File Invalid Extension JSON: %s (ext: %s)", $filepath, $ext)
        );
    }

    public static function filepathNotJson(string $filepath): self
    {
        return new self(
            message: sprintf("File is not JSON: %s", $filepath)
        );
    }

    public static function directoryNotFound(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Found: %s", $directory)
        );
    }
}
