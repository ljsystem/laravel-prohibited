<?php

namespace Ljsystem\Prohibited\Traits;

trait WithReplacer
{
    use AttributeFormatting;

    public function replacer(string $message, string $attribute, string $rule, array $parameters): string
    {
        $attribute = static::readableAttribute($attribute);
        $otherAttributes = static::readableAttributes(collect($parameters))->implode(', ');

        return trans($message, [
            'attribute' => $attribute,
            'otherAttributes' => $otherAttributes,
        ]);
    }
}
