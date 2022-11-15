<?php

namespace TallStackApp\Tools\Blade\Traits;

use TallStackApp\Tools\Support\Helper as Tall;

trait Routable
{
    /**
     * Define attributes that should be merged
     * 
     * @return array $routable
     */
    // protected array $routable = [];

    public function route(string|array $route): string|null
    {
        return Tall::route($route);
    }
}