<?php

namespace Ljsystem\Prohibited\Rules;

use Ljsystem\Prohibited\Traits\AttributeFormatting;

class Prohibited extends Rule
{
    use AttributeFormatting;

    public function extension(string $attribute): bool
    {
        $request = request();

        return ! $request->exists($attribute);
    }

    public function replacer(string $message, string $attribute): string
    {
        $attribute = static::readableAttribute($attribute);

        return trans($message, [
            'attribute' => $attribute,
        ]);
    }
}
