<?php

namespace Ja\Tall;

use Illuminate\Support\Collection;

class Helper
{
    public static function arr(...$parameters): array
    {
        return $parameters;
    }

    public static function col(...$parameters): Collection
    {
        return new Collection(
            static::arr(...$parameters)
        );
    }
}