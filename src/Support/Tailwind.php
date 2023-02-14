<?php declare (strict_types=1);

namespace Ja\Livewire\Support\Blade;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

final class Tailwind
{
    public static function tailwind(): Collection|null
    {
        $classes = Cache::get('jal-tailwindcss-classes', fn () => (
            Cache::put('jal-tailwindcss-classes', $classes = static::parseTailwindBuildSite())
                ? $classes
                : null
        ));

        return new Collection($classes);
    }

    /**
     * @param string $type
     */
    public static function byType(string $type): array
    {
        return [
            'display' => [
                'flex',
                'inline-flex',
                'block',
                'inline-block',
                'inline'
            ]
        ][$type] ?? [];
    }

    /**
     * @return ?array<string, string[]>
     */
    protected static function parseTailwindBuildSite(): ?array
    {
        try {
            $html = file_get_contents('https://tailwind.build/classes');
        } catch (Exception $e) {
            return null;
        }

        $groups = explode('<h5 class="text-2xl font-semibold mb-6">', $html);

        unset($groups[0]);
    
        $cssClassGroups = [];

        foreach ($groups as $group) {
            
            $groupKey = Str::snake(explode('</h5>', $group)[0]);

            $classes = Str::matchAll('[id="class-(\.[a-z][a-z0-9-_]*)]', $group);
            $cssClassGroups[$groupKey] = $classes;
        }

        return $cssClassGroups;
    }
}