<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Contracts;

interface UserIdentityDtoInterface
{
    public function getUsernames(): array;
    public function getRoles(): array;
    public function getPhoneNumbers(): array;
    public function getFirstNamesMale(): array;
    public function getFirstNamesFemale(): array;
    public function getLastNames(): array;
    public function getSubscriptionPlans(): array;
}
