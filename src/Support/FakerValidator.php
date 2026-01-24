<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Support;

use Vigihdev\Faker\Exceptions\FakerException;

final class FakerValidator
{
    public function __construct(
        private readonly string $filepathOrDirectory
    ) {}

    public static function validate(string $filepathOrDirectory): self
    {
        return new self($filepathOrDirectory);
    }

    public function mustExistFile(): self
    {
        $filepath = $this->filepathOrDirectory;
        if (!file_exists($filepath)) {
            throw FakerException::fileNotFound($filepath);
        }
        return $this;
    }

    public function mustBeReadable(): self
    {
        $this->mustExistFile();
        $filepath = $this->filepathOrDirectory;
        if (!is_readable($filepath)) {
            throw FakerException::fileNotReadable($filepath);
        }

        return $this;
    }

    public function mustBeExtensionJson(): self
    {
        $filepath = $this->filepathOrDirectory;
        $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        if ($ext !== 'json') {
            throw FakerException::invalidExtensionJson($filepath, $ext);
        }

        return $this;
    }
}
