<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Provider;

use Faker\Generator;
use Vigihdev\Faker\Contracts\{DtoTransformerInterface, ReviewRatingDtoInterface};
use Vigihdev\Support\Collection;

final class ReviewRating extends AbstractProvider
{
    public function __construct(
        private readonly DtoTransformerInterface $transformer,
        protected Generator $faker,
    ) {
        parent::__construct($faker);
    }

    public function generate(int $length = 1): Collection
    {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[] = $this->fields();
        }
        return new Collection($data);
    }

    private function fields()
    {
        $faker = $this->faker;
        /** @var ReviewRatingDtoInterface $riview  */
        $riview = $this->transformer->toDto();
        $categorys = array_keys($riview->getItems());
        $category = $faker->randomElement($categorys);
        $names = $riview->getItems()[$category] ?? [];

        return [
            'category' => $category,
            'name' => $faker->randomElement($names),
            'rating' => $faker->randomElement([5.0, 4.8, 4.7, 4.5, 4.3, 4.0, 3.8, 3.5]),
            'review_count' => $faker->numberBetween(8, 100),
            'price' => $this->price(),
        ];
    }
}
