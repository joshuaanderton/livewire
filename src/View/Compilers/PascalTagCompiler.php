<?php declare (strict_types=1);

namespace Ja\Livewire\View\Compilers;

use InvalidArgumentException;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Ja\Livewire\View\Components\Element;
use Ja\Livewire\View\Components\Elements;
use Ja\Livewire\Support\Blade;
use Ja\Livewire\View\Compiler;

class PascalTagCompiler extends Compiler
{
    protected function tag(): string
    {
        return '([A-Z][a-z]+(?:[A-Z][a-z]+)*)';
    }

    public function componentClass(string $component)
    {
        $componentKey = $this->componentFromTag($component);

        $topLevelComponentKey = Str::contains($componentKey, '.')
            ? Str::replace('.', '-', $componentKey)
            : null;

        if ($topLevelComponentKey && ($found = Blade::lookup($topLevelComponentKey))) {
            return $found;
        }

        if ($found = Blade::lookup($componentKey)) {
            return $found;
        }

        if (Blade::isHtml5Tag($componentKey)) {
            return Element::class;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$componentKey}]"
        );
    }
    
    private function componentFromTag(string $tag): string
    {
        // Assume plural slugs are directories/namespaces
        // e.g. IconsRocket => icons.rocket
        $componentKey = Str::snake($tag, '-');
        $componentKey = explode('-', $componentKey);
        $componentKey = (new Collection($componentKey))->map(fn ($str) => (
            Str::plural($str) == $str ? "{$str}." : "{$str}-"
        ))->join('');
        $componentKey = rtrim(rtrim($componentKey, '-'), '.');

        return $componentKey;
    }
}