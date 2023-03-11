<?php declare (strict_types=1);

namespace LivewireKit\View\Traits;

use Illuminate\Support\Arr;

trait CssClassable
{
    /**
     * Define attributes that should be css classable
     *
     * @return array<int|string, string|bool>[] $cssClassable
     */
    // protected array $cssClassable = [];

    /**
     * Get default class names (can be overriden by parent class)
     *
     * @return array
     */
    final protected function beforeRenderCssClassable(): array
    {
        $this->except = array_merge($this->except, [
            'cssClasses'
        ]);

        $cssClasses = array_merge(
            $this->getCssClasses(),
            $this->attributes['class'] ?? []
        );

        $class = $this->class ?? null;

        if (in_array('class', $this->extractPublicProperties())) {
            $cssClasses = array_merge(
                $cssClasses,
                is_string($class)
                    ? explode(' ', $class)
                    : ($class ?: [])
            );
        }

        $cssClasses = $this->mergeCssClasses($cssClasses);

        return ['class' => $cssClasses];
    }

    /**
     * Get default/preset css classes
     *
     * @return array<int|string, string|bool>
     */
    final protected function getCssClasses()
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
     * @param string|array<int|string, string|bool>|null $cssClasses
     * @param (string|array<int|string, string|bool>|null)[] $mergeCssClasses
     * @return string
     */
    private function mergeCssClasses(string|array|null $cssClasses, string|array|null ...$mergeCssClasses): string
    {
        if (! is_array($cssClasses)) {
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
     * @param string|array<int|string, string|bool> $cssClasses
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
            ->map(fn ($value) => is_string($value) ? trim($value) : null)
            ->whereNotNull();

        return Arr::toCssClasses(
            $cssClasses->all()
        );
    }
}
