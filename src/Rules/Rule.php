<?php

namespace Ljsystem\Prohibited\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class Rule
{
    public static function register()
    {
        $rule = Str::snake(last(explode('\\', get_called_class())));

        Validator::extend($rule, static::class.'@extension', trans('prohibited::validation.'.$rule));
        Validator::replacer($rule, static::class.'@replacer');
    }
}
