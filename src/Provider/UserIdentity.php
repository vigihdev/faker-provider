<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Provider;


use Faker\Generator;
use Vigihdev\Faker\Contracts\{DtoTransformerInterface, ReviewRatingDtoInterface, UserIdentityDtoInterface};
use Vigihdev\Faker\DTOs\{RegionDto};
use Vigihdev\Support\Collection;
use Vigihdev\Support\Text;

final class UserIdentity extends AbstractProvider
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
        /** @var UserIdentityDtoInterface $user */
        $user = $this->transformer->toDto();
        $region = $this->dtoTransformer->getDto(RegionDto::class);

        $username = $faker->randomElement($user->getUsernames());
        return [
            'id' => $faker->randomElement(range(10, 100)),
            'username' => $username,
            'email' => $faker->email(),
            'full_name' => Text::toTitleCase(preg_replace('/[_-]/', ' ', $username)) . ' ' . $faker->randomElement($user->getLastNames()),
            'phone_number' => $faker->randomElement($user->getPhoneNumbers()),
            'date_of_birth' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'gender' => $faker->randomElement(['male', 'female']),
            'address' => $faker->randomElement($region->getRoutes()),
            'city' => $faker->city(),
            'country' => 'Indonesia',
            'registration_date' => $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d H:i:s'),
            'is_active' => $faker->boolean(),
            'is_verified' => $faker->boolean(),
            'role' => $faker->randomElement($user->getRoles()),
            'subscription_plan' => $faker->randomElement($user->getSubscriptionPlans()),
        ];
    }
}
