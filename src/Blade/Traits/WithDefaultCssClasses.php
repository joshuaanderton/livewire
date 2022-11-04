<?php

namespace Ja\Tall\Blade\Traits;

use Ja\Tall\Blade as JaBlade;
use Illuminate\Support\Arr;
use Exception;

trait WithDefaultCssClasses
{
    /**
     * Get default class names (can be overriden by parent class)
     * 
     * @return array
     */
    protected function defaultCssClasses()
    {
        if (!is_array($this->defaultCssClasses ?? null)) {
            throw new Exception(
                join(' ', [
                    '"' . get_called_class() . '"',
                    'component class missing "$defaultCssClasses" property',
                    '(trying to use "' . self::class . '" trait)'
                ])
            );
        }
        
        return $this->defaultCssClasses;
    }

    /**
     * Get default class names (can be overriden by parent class)
     * 
     * @return array
     */
    protected function mergeClassNames(string|array $class = null): array
    {
        $class = $class ?: $this->class ?? null;

        $class = $this->mergeAll(
            $this->defaultCssClasses(),
            $class ?: '',
        );

        if (JaBlade::hasProperty($this, 'class')) {
            $this->class = $class;
        }

        return ['class' => $class];
    }

    /**
     * Merge multiple arrays or strings of classnames into one string
     *
     * @var string|array|null $classNames
     * @var array<string|array|null> $mergeClassNames
     * @return string
     */
    private function mergeAll(string|array|null $classNames, ...$mergeClassNames): string
    {
        if (!is_array($classNames)) {
            $classNames = explode(' ', (string) $classNames);
        }

        $mergeClassNames = $mergeClassNames ?: [];

        $mergeClassNames[] = $classNames;

        return collect($mergeClassNames)
                    ->whereNotNull()
                    ->map(fn ($classNames) => $this->cleanClassNames($classNames))
                    ->join(' ');
    }

    /**
     * Flatten/trim/clean array of classnames into string
     *
     * @var string|array $classNames
     * @return string
     */
    private function cleanClassNames(string|array $classNames)
    {
        if (is_string($classNames)) {
            $classNames = explode(' ', $classNames);
        }

        if (is_array($classNames)) {
            $classNames = collect($classNames);
        }

        $classNames
            ->map(fn ($className) => trim($className))
            ->filter(fn ($className) => !empty($className))
            ->whereNotNull();

        return Arr::toCssClasses(
            $classNames->all()
        );
    }
}
