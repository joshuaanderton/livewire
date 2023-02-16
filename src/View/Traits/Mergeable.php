<?php declare (strict_types=1);

namespace LivewireKit\View\Traits;

use LivewireKit\Support\Blade as JaBlade;

trait Mergeable
{
    /**
     * Define attributes that should be merged
     *
     * @return array $mergeable
     */
    // protected array $mergeable = [];

    /**
     * Merge attributes from $mergeable class property and set to class or return for $attributes
     *
     * @var array
     * @return array
     */
    protected function beforeRenderMergeable(array $mergeable = null): array
    {
        $this->except = array_merge($this->except, [
            'mergeable'
        ]);

        $mergeable = collect(array_merge(
            $this->props ?: [],
            $mergeable ?: []
        ));

        // Set class properties (if defined on class)
        collect($mergeable)
            ->filter(fn ($value, $name) => JaBlade::hasProperty($this, $name))
            ->map(fn ($value, $name) => $this->$name = $value);

        // Return attributes that are not properties nor in $except array
        return $mergeable
                    ->filter(fn ($value, $name) => (
                        ! JaBlade::hasProperty($this, $name) &&
                        ! in_array($name, $this->except)
                    ))
                    ->all();
    }
}
