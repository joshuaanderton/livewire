<?php

namespace TallStackApp\Tools\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Helper
{
    protected const packagePath = __DIR__ . '/../../';

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
        $path = join('/', $parameters);
        $path = base_path($path);

        // Clean up any double slashes from concatenation
        $path = Str::replace('//', '/', $path);

        return $path;
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
        $path = join('/', [
            static::packagePath,
            ...$parameters
        ]);

        // Clean up any double slashes from concatenation
        $path = Str::replace('//', '/', $path);

        return $path;
    }

    public static function packageViewsPath(string ...$parameters)
    {
        return static::packagePath(
            'resources/views',
            ...$parameters
        );
    }

    public static function route(string|array $route, array $params = [], bool $absolute = false)
    {
        if (is_array($route)) {
            @list($routeName, $routeParams, $routeAbsolute) = $route;

            return route(
                $routeName,
                $routeParams ?: $params,
                $routeAbsolute ?: $absolute
            );
        }
    
        return route(
            $route,
            $params,
            $absolute
        );
    }
}