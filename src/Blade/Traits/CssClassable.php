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
     * @return array
     */
    protected function getCssClassable(): array
    {
        $this->except = array_merge($this->except, [
            'cssClasses'
        ]);

        $cssClasses = array_merge(
            $this->getCssClasses(),
            $this->attributes['class'] ?? []
        );

        if (in_array('class', $this->extractPublicProperties())) {
            $cssClasses = array_merge($cssClasses,
                is_string($this->class)
                    ? explode(' ', $this->class)
                    : ($this->class ?: [])
            );
        }

        $cssClasses = $this->mergeCssClasses($cssClasses);

        return ['class' => $cssClasses];
    }

    /**
     * Get default/preset css classes
     * 
     * @return array
     */
    protected function getCssClasses()
    {
        return array_merge(
            
            $this->cssClasses ?? [],

            method_exists($this, 'cssClasses')
                ? $this->cssClasses()
                : []

        );
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
