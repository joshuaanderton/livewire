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

    public function beforeRenderRoutable(array $data): array
    {
        if (isset($data['routable'])) unset($data['routable']);
        
        $attributes = $data['attributes'];

        if (
            ! $this->hasProp('routable') ||
            empty($routable = $this->routable)
        ) {
            return $data;
        }

        $routed = (
            collect($attributes)
                ->filter(fn ($value, $key) => in_array($key, $routable))
                ->map(fn ($value, $key) => $this->route($value))
        );

        $data['attributes'] = array_merge($attributes, $routed);

        return $data;
    }

    public function route(string|array $route): string|null
    {
        return Tall::route($route);
    }
}