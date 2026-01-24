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
    private array $usedPhones = [];

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

        // $email = $this->generateEmailFromUsername($username, $fullName);
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

    private function generateUniqueUsername(string $fullName, int $index): string
    {
        $name = strtolower(str_replace(' ', '', $fullName));
        $firstName = strtolower(explode(' ', $fullName)[0]);

        // 10 different username patterns untuk mengurangi duplikat
        $patterns = [
            // Pattern 1: fullname + angka 2 digit
            $name . sprintf('%02d', $this->faker->numberBetween(1, 99)),

            // Pattern 2: nama depan + angka 3 digit
            $firstName . sprintf('%03d', $this->faker->numberBetween(100, 999)),

            // Pattern 3: nama depan + underscore + kata
            $firstName . '_' . $this->faker->randomElement(['cool', 'boss', 'team', 'pro', 'tech', 'dev']),

            // Pattern 4: nama depan + inisial belakang + angka
            $firstName . substr(strtolower(explode(' ', $fullName)[1] ?? ''), 0, 1) .
                $this->faker->numberBetween(10, 99),

            // Pattern 5: nickname + tahun lahir
            $this->faker->randomElement(['bud', 'jok', 'agus', 'sari', 'dew']) .
                $this->faker->numberBetween(80, 99),

            // Pattern 6: kombinasi nama + random chars
            substr($firstName, 0, 3) . substr($name, -3) .
                $this->faker->randomElement(['x', 'z', '_']),

            // Pattern 7: dengan titik
            $firstName . '.' . strtolower(explode(' ', $fullName)[1] ?? '') .
                $this->faker->numberBetween(1, 9),

            // Pattern 8: reverse name
            strrev(substr($firstName, 0, 4)) . $this->faker->numberBetween(100, 999),

            // Pattern 9: dengan tahun
            $firstName . date('y') . $this->faker->numberBetween(1, 9),

            // Pattern 10: simple random
            $firstName . $this->faker->lexify('???') . $this->faker->numerify('##')
        ];

        // Pakai index sebagai seed tambahan untuk uniqueness
        $patternIndex = ($index % count($patterns));
        return $patterns[$patternIndex];
    }

    private function generateEmailFromUsername(string $username, string $fullName): string
    {
        $nameParts = explode(' ', $fullName);
        $firstName = strtolower($nameParts[0]);
        $lastName = isset($nameParts[1]) ? strtolower($nameParts[1]) : '';

        // 15+ domain Indonesia yang realistis
        $domains = [
            'gmail.com',
            'yahoo.com',
            'outlook.com',
            'hotmail.com',
            'email.id',
            'yahoo.co.id',
            'rocketmail.com',
            // Domain perusahaan Indonesia
            'telkom.net',
            'indosat.net.id',
            'xl.co.id',
            // Domain lokal
            'student.university.ac.id',
            'company.co.id',
            'office.id'
        ];

        // 8 pattern email berbeda
        $patterns = [
            // user.name@domain
            str_replace('_', '.', $username) . '@' . $this->faker->randomElement($domains),

            // first.last@domain
            $firstName . '.' . $lastName . '@' . $this->faker->randomElement($domains),

            // first_last@domain  
            $firstName . '_' . $lastName . '@' . $this->faker->randomElement($domains),

            // first+last@domain
            $firstName . $lastName . '@' . $this->faker->randomElement($domains),

            // f.last@domain (initial)
            substr($firstName, 0, 1) . '.' . $lastName . '@' . $this->faker->randomElement($domains),

            // first@domain (simple)
            $firstName . '@' . $this->faker->randomElement($domains),

            // username dengan angka@domain
            $username . $this->faker->numberBetween(1, 9) . '@' . $this->faker->randomElement($domains),

            // nama dengan tahun@domain
            $firstName . date('y') . '@' . $this->faker->randomElement($domains)
        ];

        return $this->faker->randomElement($patterns);
    }

    private function generateUniquePhone(): string
    {
        do {
            $prefixes = ['0811', '0812', '0813', '0816', '0817', '0852', '0853', '0878', '0896', '0898'];
            $middle = sprintf('%03d', rand(100, 999));
            $last = sprintf('%03d', rand(100, 999));

            $phone = $this->faker->randomElement($prefixes) . ' ' . $middle . ' ' . $last;
        } while (in_array($phone, $this->usedPhones));

        $this->usedPhones[] = $phone;
        return $phone;
    }
}
