<?php

namespace Ja\Livewire\Blade\Traits;

use Ja\Livewire\Support\Helper as Tall;

trait Routable
{
    /**
     * Define attributes that should be merged
     * 
     * @return array $routable
     */
    // protected array $routable = [];

    protected function beforeRenderRoutable(array $routable = null): array
    {
        if ($this->routable ?? false) {
            $routable = (
                collect($this->routable)
                    ->map(fn ($name) => [$name => $this->$name])
                    ->collapse()
                    ->union($routable ?: [])
                    ->all()
            );
        }

        $routed = collect($routable)->map(fn ($value, $name) => $this->route($value));
        
        // Set class properties (if defined on class)
        collect($routed)
            ->filter(fn ($value, $name) => $this->hasProp($name))
            ->map(fn ($value, $name) => $this->$name = $value);

        // Return routed attributes that are not properties nor in $except array
        return $routed
                    ->filter(fn ($value, $name) => (
                        ! $this->hasProp($name) &&
                        ! in_array($name, $this->except)
                    ))
                    ->all();
    }

    public function route(string|array $route): string|null
    {
        return Tall::route($route);
    }
}