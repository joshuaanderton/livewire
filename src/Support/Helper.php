<?php

namespace TallStackApp\Tools\Support;

use Exception;
use Illuminate\Support\Facades\File;
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

    public static function file(string $name, array $data = [])
    {
        try {
            
            // Check for override
            return File::get("vendors/tallstackapp/{$name}");

        } catch (Exception $e) {
            //
        }

        return File::get(
            static::packageViewsPath($name)
        );
    }

    public static function view(string $name, array $data = [])
    {
        try {
            
            // Check for override
            return view("vendors/tallstackapp/{$name}", $data);

        } catch (Exception $e) {
            //
        }

        return view("tall::{$name}", $data);
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