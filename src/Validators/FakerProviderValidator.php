<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Validators;

use Vigihdev\FakerProvider\Exceptions\FakerProviderException;

final class FakerProviderValidator
{
    public function __construct(
        private readonly string $filepath,
        private readonly ?string $directory = null
    ) {}

    public static function validate(string $filepath, ?string $directory = null): self
    {
        return new self($filepath, $directory);
    }

    public function mustExistFile(): self
    {
        if (!file_exists($this->filepath)) {
            throw FakerProviderException::filepathNotFound($this->filepath);
        }
        return $this;
    }

    public function mustBeReadable(): self
    {
        $this->mustExistFile();

        if (!is_readable($this->filepath)) {
            throw FakerProviderException::filepathNotReadable($this->filepath);
        }

        return $this;
    }

    public function mustBeExtensionJson(): self
    {
        $ext = strtolower(pathinfo($this->filepath, PATHINFO_EXTENSION));
        if ($ext !== 'json') {
            throw FakerProviderException::filepathInvalidExtensionJson($this->filepath, $ext);
        }

        return $this;
    }
}
