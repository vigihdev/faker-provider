<?php

declare(strict_types=1);

namespace Vigihdev\FakerProvider\Providers;

use Faker\Provider\Base;
use Faker\Generator;
use Symfony\Component\Filesystem\Path;
use Vigihdev\FakerProvider\Enums\ProviderResource;
use Vigihdev\FakerProvider\Factory\DtoTransformer;

abstract class AbstractProvider extends Base
{

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    protected function loadData(ProviderResource $resource): array|object
    {
        $filepath = Path::join(getcwd(), getenv('ID_RESOURCE_PATH'), $resource->getPath());
        return DtoTransformer::fromJsonFile($filepath, $resource->getDtoClass());
    }
}
