<?php

namespace Ja\Livewire\Blade\Traits;

use Ja\Livewire\Support\Blade as JaBlade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

trait Translatable
{
    /**
     * Define attributes that should be translated
     * 
     * @return ?array
     */
    // protected array $translatable = [];

    /**
     * Translate translatable fields
     * 
     * @var array $translatable
     * @return array
     */
    protected function beforeRenderTranslatable(array $data): array
    {
        if (isset($data['translatable'])) unset($data['translatable']);

        $attributes = $data['attributes'];

        if (
            ! $this->hasProp('translatable') ||
            empty($translatable = $this->translatable)
        ) {
            return $data;
        }

        $translated = (
            collect($attributes)
                ->filter(fn ($value, $key) => in_array($key, $translatable))
                ->map(fn ($value, $key) => $this->translate($value))
        );

        $data['attributes'] = array_merge($attributes, $translated);

        return $data;
    }

    protected function translate()
    {
        if (
            ! Str::contains($key, '.') || 
            ! Lang::has($key) ||
            is_array($translated = Lang::get($key))
        ) {
            return $key;
        }

        return $translated;
    }
}
