<?php

namespace Ja\View\Blade\Traits;

trait WithRoute
{
    public function routePath(string|array $route): string|null
    {
        if (is_array($route)) {
            list($name, $params, $absolute) = $route;

            return route(
                $name,
                $params ?: [],
                $absolute ?: false
            );
        }
    
        return route($route);
    }
}