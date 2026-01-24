<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Exceptions;

use Throwable;

class FakerException extends AbstractFakerException
{

    public static function handleThrowable(Throwable|FakerExceptionInterface $e, array $context = [], array $solutions = []): self
    {
        $context = method_exists($e, 'getContext') && is_array($e->getContext()) ? $e->getContext() : $context;
        $solutions = method_exists($e, 'getSolutions') && is_array($e->getSolutions()) ? $e->getSolutions() : $solutions;
        return new self(
            message: $e->getMessage(),
            code: $e->getCode(),
            previous: $e,
            context: $context,
            solutions: $solutions,
        );
    }

    public static function fileExist(string $filepath): self
    {
        return new self(
            message: sprintf("File Exist: %s", $filepath),
            code: 409,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file exists',
            ],
        );
    }

    public static function fileNotFound(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Found: %s", $filepath),
            code: 404,
            previous: null,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file exists',
                'Check if the file is readable',
            ],
        );
    }

    public static function fileNotReadable(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Readable: %s", $filepath),
            code: 403,
            previous: null,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file is readable',
            ],
        );
    }

    public static function fileNotWritable(string $filepath): self
    {
        return new self(
            message: sprintf("File Not Writable: %s", $filepath),
            code: 403,
            previous: null,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file is writable',
            ],
        );
    }

    public static function invalidExtensionJson(string $filepath): self
    {
        return new self(
            message: sprintf("File Extension Invalid: %s", $filepath),
            code: 400,
            previous: null,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file extension is json',
            ],
        );
    }

    public static function invalidCreateFile(string $filepath): self
    {
        return new self(
            message: sprintf("Failed to create file: %s", $filepath),
            code: 403,
            previous: null,
            context: [
                'filepath' => $filepath,
            ],
            solutions: [
                'Check if the file is writable',
            ],
        );
    }

    public static function invalidCreateDirectory(string $directory): self
    {
        return new self(
            message: sprintf("Failed to create directory: %s", $directory),
            code: 403,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory is writable',
            ],
        );
    }

    public static function directoryNotFound(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Found: %s", $directory),
            code: 404,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory exists',
                'Check if the directory is readable',
            ],
        );
    }

    public static function directoryNotReadable(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Readable: %s", $directory),
            code: 403,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory is readable',
            ],
        );
    }

    public static function directoryNotWritable(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Writable: %s", $directory),
            code: 403,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory is writable',
            ],
        );
    }

    public static function directoryNotExist(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Exist: %s", $directory),
            code: 404,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory exists',
            ],
        );
    }

    public static function directoryNotAbsolute(string $directory): self
    {
        return new self(
            message: sprintf("Directory Not Absolute: %s", $directory),
            code: 403,
            previous: null,
            context: [
                'directory' => $directory,
            ],
            solutions: [
                'Check if the directory is absolute',
            ],
        );
    }
}
