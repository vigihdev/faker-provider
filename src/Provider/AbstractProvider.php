<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Provider;

use Faker\Generator;
use Vigihdev\Faker\Contracts\DtoTransformerManagerInterface;
use Vigihdev\Faker\Contracts\ProviderInterface;
use VigihDev\SymfonyBridge\Config\Service\ServiceLocator;

abstract class AbstractProvider implements ProviderInterface
{

    private array $usedPhones = [];

    protected ?DtoTransformerManagerInterface $dtoTransformer = null;

    public function __construct(
        protected Generator $faker,
        ?DtoTransformerManagerInterface $dtoTransformer = null,
    ) {

        if ($dtoTransformer === null) {
            if (ServiceLocator::has(DtoTransformerManagerInterface::class)) {
                $this->dtoTransformer = ServiceLocator::get(DtoTransformerManagerInterface::class);
            }
        }
    }

    protected function price(): int
    {
        $start = 250000;
        $prices = [];
        for ($i = 0; $i < 10; $i++) {
            $price = $start + ($i * 25000);
            $prices[] = $price;
        }
        return $this->faker->randomElement($prices);
    }

    protected function generateUniqueUsername(string $fullName, int $index): string
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

    protected function generateEmailFromUsername(string $username, string $fullName): string
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


    protected function generateUniquePhone(): string
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
