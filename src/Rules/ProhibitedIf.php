<?php

namespace Ljsystem\Prohibited\Rules;

use Ljsystem\Prohibited\Traits\IfUnlessReplacer;

class ProhibitedIf extends Rule
{
    use IfUnlessReplacer;

    public function extension(string $attribute, $value, array $parameters): bool
    {
        $otherAttribute = $parameters[0];
        $otherValues = array_slice($parameters, 1);

        $request = request();

        if (! $request->exists($attribute)) {
            return true;
        }

        if (! $request->exists($otherAttribute)) {
            return true;
        }

        return ! (in_array($request->input($otherAttribute), $otherValues));
    }
}
