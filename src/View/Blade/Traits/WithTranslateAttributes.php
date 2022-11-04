<?php

namespace Ja\View\Blade\Traits;

use Ja\Tall\Blade as JaBlade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

trait WithTranslateAttributes
{
    /**
     * Translate translateable fields
     * 
     * @var array $translateable
     * @return array
     */
    protected function translateAttributes(array $translateableData = null): array
    {
        if ($this->translateable ?? false) {
            $translateableData = collect($this->translateable)
                                    ->map(fn ($name) => [$name => $this->$name])
                                    ->collapse()
                                    ->union($translateableData ?: [])
                                    ->all();
        }

        $translated = collect($translateableData)
                        ->map(fn ($value, $name) => (
                            Str::contains($value, '.') && Lang::has($value)
                                ? Lang::get($value)
                                : $value
                        ));
        
        // Set class properties (if defined on class)
        collect($translated)
            ->filter(fn ($value, $name) => JaBlade::hasProperty($this, $name))
            ->map(fn ($value, $name) => $this->$name = $value);

        // Return translated attributes that are not properties nor in $except array
        return $translated
                    ->filter(fn ($value, $name) => (
                        !JaBlade::hasProperty($this, $name) &&
                        !in_array($name, $this->except)
                    ))
                    ->all();
    }
}
