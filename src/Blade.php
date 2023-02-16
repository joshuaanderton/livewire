<?php

namespace LivewireKit;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use LivewireKit\View\Traits\CssClassable;
use LivewireKit\View\Traits\Mergeable;
use LivewireKit\View\Traits\Routable;
use LivewireKit\View\Traits\Translatable;
use LivewireKit\Support\Blade as LivewireKitBlade;
use LivewireKit\Support\Helper as LivewireKit;

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

        return LivewireKit::view($name, $data)->render();
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
        $viewPath = Str::remove('LivewireKit\\View\\Components\\', $viewPath);
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
        return Str::startsWith($this->componentClass(), 'App\\View\\Components');
    }

    /**
     * Wrapper for componentHasTrait
     *
     * @return bool
     */
    protected function hasTrait(string $trait): bool
    {
        $componentClass = get_called_class();

        return (
            LivewireKitBlade::componentHasTrait($componentClass, $trait) ||
            LivewireKitBlade::componentHasTrait(get_parent_class($componentClass), $trait)
        );
    }
}
