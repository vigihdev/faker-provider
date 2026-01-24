<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Provider;


use Faker\Generator;
use Vigihdev\Faker\Contracts\{DtoTransformerInterface, ReviewRatingDtoInterface, UserIdentityDtoInterface};
use Vigihdev\Faker\DTOs\{RegionDto};
use Vigihdev\Support\Collection;

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
        $usedUsernames = [];

        for ($i = 0; $i < $length; $i++) {
            $fields = $this->fields($i, $usedUsernames);
            $usedUsernames[] = $fields['username'];
            $data[] = $fields;
        }
        return new Collection($data);
    }

    private function fields(int $index, array &$usedUsernames): array
    {
        $faker = $this->faker;
        /** @var UserIdentityDtoInterface $user */
        $user = $this->transformer->toDto();
        $region = $this->dtoTransformer->getDto(RegionDto::class);

        $username = $faker->randomElement($user->getUsernames());
        do {
            $gender = $this->faker->randomElement(['male', 'female']);
            $fullName = $this->generateIndonesianName($gender);
            $username = $this->generateUniqueUsername($fullName, $index);
        } while (in_array($username, $usedUsernames));

        return [
            'id' => $faker->unique()->numberBetween(1000, 9999),
            'username' => $this->generateUniqueUsername($fullName, $index),
            'email' => $this->generateEmailFromUsername($username, $fullName),
            'full_name' => $fullName,
            'phone_number' => $this->generateUniquePhone(),
            'date_of_birth' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'gender' => $gender,
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

    private function generateIndonesianName(?string $gender = null): string
    {
        $gender = $gender ?? $this->faker->randomElement(['male', 'female']);
        /** @var UserIdentityDtoInterface $user */
        $user = $this->transformer->toDto();

        if ($gender === 'male') {
            $firstNames = $user->getFirstNamesMale();
        } else {
            $firstNames = $user->getFirstNamesFemale();
        }

        $lastNames = $user->getLastNames();

        return $this->faker->randomElement($firstNames) . ' ' .
            $this->faker->randomElement($lastNames);
    }
}
