<?php

namespace Ljsystem\Prohibited\Rules;

use Ljsystem\Prohibited\Traits\WithReplacer;

class ProhibitedWith extends Rule
{
    use WithReplacer;

    public function extension(string $attribute, $value, array $parameters): bool
    {
        $request = request();

        if (! $request->exists($attribute)) {
            return true;
        }

        foreach($parameters as $parameter) {
            return ! $request->exists($parameter);
        }

        return true;
    }
}
