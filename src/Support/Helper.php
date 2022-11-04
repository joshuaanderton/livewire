<?php

namespace Ja\Tall\Support;

use Illuminate\Support\Collection;

class Helper
{
    protected const packagePath = __DIR__ . '../../';

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

    public static function path(string ...$parameters): string
    {
        return base_path(
            join('/', $parameters)
        );
    }

    public static function vendorPath(string ...$parameters): string
    {
        return static::path(
            'vendor',
            ...$parameters
        );
    }

    public static function viewsPath(string ...$parameters): string
    {
        return static::path(
            'resources/views',
            ...$parameters
        );
    }

    public static function packagePath(string ...$parameters): string
    {
        return join('/', array_merge([static::packagePath], $parameters));
    }

    public static function packageViewsPath(string ...$parameters)
    {
        return static::packagePath(
            'resources/views',
            ...$parameters
        );
    }
}