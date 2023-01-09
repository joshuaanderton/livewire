<?php

namespace Ja\Livewire\Blade\Traits;

use Ja\Livewire\Support\Blade as JaBlade;

trait Mergeable
{
    /**
     * Define attributes that should be merged into component attributes bag/array
     * 
     * @return array $props
     */
    // protected array $mergeable = [];

    /**
     * Merge attributes from $mergeable class property and set to class or return for $attributes
     * 
     * @var array $attributes
     * @return array
     */
    protected function beforeRenderMergeable(array $data): array
    {
        if (isset($data['mergable'])) unset($data['mergable']);

        $attributes = $data['attributes'];

        if (
            ! $this->hasProp('mergable') ||
            empty($mergable = $this->mergable)
        ) {
            return $data;
        }

        $merged = (
            collect($attributes)
                ->filter(fn ($value, $key) => in_array($key, $mergable))
                ->map(fn ($value, $key) => $this->merge($value))
        );

        $data['attributes'] = array_merge($attributes, $merged);

        return $data;

        if (isset($data['mergeable'])) unset($data['mergeable']);
        
        $mergeable = collect(array_merge(
            $this->props ?: [],
            $mergeable ?: []
        ));

        // Set class properties (if defined on class)
        collect($mergeable)
            ->filter(fn ($value, $name) => $this->hasProp($name))
            ->map(fn ($value, $name) => $this->$name = $value);

        // Return attributes that are not properties nor in $except array
        return $mergeable
                    ->filter(fn ($value, $name) => (
                        !JaBlade::hasProperty($this, $name) &&
                        !in_array($name, $this->except)
                    ))
                    ->all();
    }
}
