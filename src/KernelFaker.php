<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider;

use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Filesystem\Path;
use Vigihdev\FakerProvider\Exceptions\FakerProviderException;
use Vigihdev\FakerProvider\Providers\Id\Address\{ProvinceIdProvider, VillageIdProvider};
use VigihDev\SymfonyBridge\Config\ConfigBridge;

final class KernelFaker
{
    private static ?Generator $faker = null;

    private string $basepath = '';

    private array $envFilenames = [];

    public static function createIndonesiaFaker(): Generator
    {
        $kernel = new self();
        $kernel->boot();

        $faker = Factory::create('id_ID');
        $faker->addProvider(new ProvinceIdProvider($faker));
        $faker->addProvider(new VillageIdProvider($faker));

        return $faker;
    }


    public function __construct()
    {
        $this->basepath = getcwd() ?? '';
        $this->envFilenames = ['.env'];
    }

    private function boot(): void
    {

        if (!is_dir($this->basepath)) {
            throw FakerProviderException::directoryNotFound((string) $this->basepath);
        }

        $fileService = Path::join($this->basepath, 'config', 'services.yaml');
        if (!is_file($fileService)) {
            throw FakerProviderException::filepathNotFound((string) $fileService);
        }

        $container = ConfigBridge::boot(
            basePath: $this->basepath,
            configDir: 'config',
            enableAutoInjection: true
        );

        foreach ($this->envFilenames as $filename) {
            $envPath = Path::join($this->basepath, $filename);
            if (is_file($envPath)) {
                $container->loadEnv($envPath);
            }
        }
    }
}
