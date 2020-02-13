<?php

namespace Ljsystem\Prohibited\Traits;

trait IfUnlessReplacer
{
    use AttributeFormatting;

    public function replacer(string $message, string $attribute, string $rule, array $parameters): string
    {
        $attribute = static::readableAttribute($attribute);
        $otherAttribute = static::readableAttribute($parameters[0]);
        $otherValues = static::readableAttributes(collect(array_slice($parameters, 1)))->implode(', ');

        return trans($message, [
            'attribute' => $attribute,
            'otherAttribute' => $otherAttribute,
            'otherValue' => $otherValues,
        ]);
    }
}
