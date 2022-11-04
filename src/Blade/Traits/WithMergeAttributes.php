<?php

namespace Ja\Tall\Blade\Traits;

use Ja\Tall\Blade as JaBlade;

trait WithMergeAttributes
{
    /**
     * Define attributes that should be merged
     * 
     * @return ?array
     */
    public ?array $mergeable = null;

    /**
     * Merge attributes from $mergeable class property and set to class or return for $attributes
     * 
     * @var array $mergeable
     * @return array
     */
    protected function mergeAttributes(array $mergeable = null): array
    {
        $mergeable = collect(array_merge(
            $this->mergeable ?: [],
            $mergeable ?: []
        ));

        // Set class properties (if defined on class)
        collect($mergeable)
            ->filter(fn ($value, $name) => JaBlade::hasProperty($this, $name))
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
