<?php

namespace Ja\View\Blade\Traits;

use Illuminate\Support\Facades\File;
use Ja\Tall\Blade as JaBlade;

trait WithTailwindMerge
{
    private function tailwindCssClasses()
    {
        if (File::exists($manifestPath = base_path('public/build/manifest.json')) $manifest = json_decode()
    }

    /**
     * Merge list of tailwind CSS classes
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
