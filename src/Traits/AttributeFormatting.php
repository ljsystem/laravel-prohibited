<?php

namespace Ljsystem\Prohibited\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait AttributeFormatting
{
    private static function readableAttribute(string $attribute): string
    {
        return str_replace('_', ' ', Str::snake($attribute));
    }

    private static function readableAttributes(Collection $attributes): Collection
    {
        return $attributes->map(function ($attribute) {
            return static::readableAttribute($attribute);
        });
    }
}
