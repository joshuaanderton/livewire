<?php

namespace Ja\Tall\View\Objects;

use Illuminate\Support\Facades\Lang;

class NavItem
{
    public string $name;

    public string $href;

    public ?string $icon;

    public bool $current;

    public function __construct(
        string $name,
        string $route = null,
        string $href = null,
        string $icon = null,
        bool $current = null
    )
    {
        if (Lang::has($name) && !is_array($trName = Lang::get($name))) {
            $this->name = $trName;
        } else {
            $this->name = $name;
        }

        $this->icon = $icon;
        
        if ($route) {
            $this->href = route($route);
        } else {
            $this->href = $href;
        }

        $this->current = ! ! $current;
    }
}