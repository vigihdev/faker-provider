<?php

declare(strict_types=1);

namespace Vigihdev\Faker\DTOs;

use Vigihdev\Faker\Contracts\UserIdentityDtoInterface;

final class UserIdentityDto implements UserIdentityDtoInterface
{
    public function __construct(
        private readonly array $usernames = [],
        private readonly array $roles = [],
        private readonly array $phone_numbers = [],
        private readonly array $first_names_male = [],
        private readonly array $first_names_female = [],
        private readonly array $last_names = [],
        private readonly array $subscription_plans = [],
    ) {}

    public function getUsernames(): array
    {
        return $this->usernames;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPhoneNumbers(): array
    {
        return $this->phone_numbers;
    }

    public function getSubscriptionPlans(): array
    {
        return $this->subscription_plans;
    }

    public function getFirstNamesMale(): array
    {
        return $this->first_names_male;
    }

    public function getFirstNamesFemale(): array
    {
        return $this->first_names_female;
    }

    public function getLastNames(): array
    {
        return $this->last_names;
    }
}
