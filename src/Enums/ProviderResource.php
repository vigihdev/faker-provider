<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Enums;

use Vigihdev\Faker\DTOs\{ReviewRatingDto, UserIdentityDto};

enum ProviderResource: string
{
    case USER_IDENTITY = 'resources/user-identities';
    case REVIEW_RATING = 'resources/review-ratings';

    public function getDtoClass(): string
    {
        return match ($this) {
            self::USER_IDENTITY => UserIdentityDto::class,
            self::REVIEW_RATING => ReviewRatingDto::class,
        };
    }

    public function getPath(): string
    {
        return "{$this->value}.json";
    }
}
