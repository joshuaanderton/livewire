<?php

namespace Ja\Livewire;

use Closure;
use Ja\Livewire\Support\Blade as TallBlade;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\CssClassable;
use Ja\Livewire\Blade\Traits\Translatable;
use Ja\Livewire\Blade\Traits\Routable;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Ja\Livewire\Support\Helper as Tall;

class Blade extends Component
{
    protected array $props = [];

    public function render()
    {
        if ($this->hasProp('if') && $this->if === false) {
            return '';
        }

        $addAttributes = $this->triggerHelperTraits('beforeRender');

        return fn ($data) => $this->setupRender($data, $addAttributes);
    }

    protected function setupRender(array $data, array $addAttributes = null)
    {
        if ($addAttributes) {
            $data['attributes'] = $data['attributes']->merge(
                $addAttributes
            );
        }

        if ($wireModel = $data['attributes']->wire('model')->value()) {
            $data['model'] = $data['model'] ?? $wireModel;
        }
        
        $name = $this->componentViewPath();

        if ($this->isProjectComponent()) {
            return view($name, $data)->render();
        }

        return Tall::view($name, $data)->render();
    }

    private function triggerHelperTraits(string $event)
    {
        $helperTraits = [
            Mergeable::class,
            CssClassable::class,
            Translatable::class,
            Routable::class,
        ];

        return (
            collect($helperTraits)
                ->filter(fn ($trait) => $this->hasTrait($trait))
                ->map(function ($trait) use ($event) {
                    $trait = class_basename($trait);
                    $method = "{$event}{$trait}";
                    return $this->$method();
                })
                ->collapse()
                ->all()
        );
    }

    protected function componentViewPath(): string
    {
        // Allow overriding view path from child class
        if ($this->hasProp('componentViewPath')) {
            return $this->componentViewPath;
        }

        $class = $this->componentClass();

        $viewPath = $class;
        $viewPath = Str::remove('App\\View\\Components\\', $viewPath);
        $viewPath = Str::remove(self::class . '\\', $viewPath);
        $viewPath = (
            collect(explode('\\', $viewPath))
                ->map(fn ($slug) => Str::snake($slug, '-'))
                ->join('.')
        );

        return "components.{$viewPath}";
    }

    protected function componentClass()
    {
        return get_called_class();
    }

    protected function hasProp(string $name): bool
    {
        return property_exists($this->componentClass(), $name);
    }
    
    protected function isProjectComponent(): bool
    {
        return Str::startsWith($this->componentClass(), 'App\\View\\Components\\');
    }

    /**
     * Wrapper for componentHasTrait
     *
     * @return boolean
     */
    protected function hasTrait(string $trait): bool
    {
        $componentClass = get_called_class();

        return (
            TallBlade::componentHasTrait($componentClass, $trait) ||
            TallBlade::componentHasTrait(get_parent_class($componentClass), $trait)
        );
    }
}
