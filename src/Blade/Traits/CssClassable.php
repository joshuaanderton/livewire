<?php

namespace Ja\Livewire\Blade\Traits;

use Illuminate\Support\Arr;

trait CssClassable
{
    /**
     * Define attributes that should be css classable
     * 
     * @return array $cssClassable
     */
    // protected array $cssClassable = [];

    /**
     * Get default class names (can be overriden by parent class)
     * 
     * @var array $attributes
     * @return array
     */
    protected function beforeRenderCssClassable(array $data): array
    {
        if (isset($data['cssClassable'])) unset($data['cssClassable']);

        $attributes = $data['attributes'];

        $cssClasses = array_merge(

            $this->hasProp('cssClasses')
                ? $this->cssClasses
                : [],

            method_exists($this, 'cssClasses')
                ? $this->cssClasses()
                : [],

            $attributes['class'] ?? [],

            $data['class'] ?? []
        );

        $cssClasses = $this->mergeCssClasses($cssClasses);

        $attributes['class'] = $

        return ['class' => $cssClasses];
    }

    /**
     * Merge multiple arrays or strings of classnames into one string
     *
     * @var string|array|null $cssClasses
     * @var array<string|array|null> $mergeCssClasses
     * @return string
     */
    private function mergeCssClasses(string|array|null $cssClasses, ...$mergeCssClasses): string
    {
        if (!is_array($cssClasses)) {
            $cssClasses = explode(' ', (string) $cssClasses);
        }

        $mergeCssClasses = $mergeCssClasses ?: [];

        $mergeCssClasses[] = $cssClasses;

        return (
            collect($mergeCssClasses)
                ->whereNotNull()
                ->map(fn ($cssClasses) => $this->cleanCssClasses($cssClasses))
                ->join(' ')
        );
    }

    /**
     * Flatten/trim/clean array of classnames into string
     *
     * @var string|array $cssClasses
     * @return string
     */
    private function cleanCssClasses(string|array $cssClasses)
    {
        if (is_string($cssClasses)) {
            $cssClasses = explode(' ', $cssClasses);
        }

        if (is_array($cssClasses)) {
            $cssClasses = collect($cssClasses);
        }

        $cssClasses
            ->map(fn ($className) => trim($className))
            ->filter(fn ($className) => !empty($className))
            ->whereNotNull();

        return Arr::toCssClasses(
            $cssClasses->all()
        );
    }
}
