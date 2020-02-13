<?php

namespace Ljsystem\Prohibited\Rules;

use Ljsystem\Prohibited\Traits\WithReplacer;

class ProhibitedWithAll extends Rule
{
    use WithReplacer;

    public function extension(string $attribute, $value, array $parameters): bool
    {
        $request = request();

        if (! $request->exists($attribute)) {
            return true;
        }

        return ! $request->exists($parameters);
    }
}
