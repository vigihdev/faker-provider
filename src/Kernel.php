<?php

declare(strict_types=1);

namespace Vigihdev\Faker;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Path;
use Vigihdev\Faker\Exceptions\FakerException;
use VigihDev\SymfonyBridge\Config\ConfigBridge;

final class Kernel
{

    private const PACKAGE_NAME = 'faker-provider';
    private const VENDOR_PACKAGE_NAME = 'vendor/vigihdev/faker-provider';

    public static function boot(string $basepath, $envFilenames = ['.env']): self
    {
        return new self($basepath, $envFilenames);
    }

    public function __construct(
        private readonly string $basepath,
        private readonly array $envFilenames = ['.env']
    ) {

        $this->initialize();
    }

    private function initialize(): void
    {
        $basepath = $this->actualBasepath($this->basepath);

        if (!is_dir($basepath)) {
            throw FakerException::directoryNotFound((string) $basepath);
        }

        $fileService = Path::join($basepath, 'config', 'services.yaml');
        if (!is_file($fileService)) {
            throw FakerException::fileNotFound((string) $fileService);
        }

        // Load env
        $envDefaults = [
            'PROJECT_DIR' => Path::join(__DIR__, '..')
        ];
        $dotEnv = new Dotenv();
        $dotEnv->usePutenv(true);
        $dotEnv->populate($envDefaults, true);


        $container = ConfigBridge::boot(
            basePath: $basepath,
            configDir: 'config',
            enableAutoInjection: true
        );

        foreach ($this->envFilenames as $filename) {
            $envPath = Path::join($basepath, $filename);
            if (is_file($envPath)) {
                $container->loadEnv($envPath);
            }
        }
    }

    private function actualBasepath(string $basepath): string
    {

        $basepath = realpath($basepath);
        if ($basepath === false) {
            throw FakerException::directoryNotFound((string) $basepath);
        }

        $basename = pathinfo($basepath, PATHINFO_BASENAME);
        if ($basename === self::PACKAGE_NAME && is_dir(Path::join($basepath, 'vendor'))) {
            return $basepath;
        }

        $basepath = Path::join($basepath, self::VENDOR_PACKAGE_NAME);
        if (!is_dir($basepath)) {
            throw FakerException::directoryNotFound((string) $basepath);
        }

        return $basepath;
    }
}
