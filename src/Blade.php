<?php

namespace Ja\Livewire;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Ja\Livewire\Support\Blade as TallBlade;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\CssClassable;
use Ja\Livewire\Blade\Traits\Translatable;
use Ja\Livewire\Blade\Traits\Routable;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Ja\Livewire\Support\Helper as Tall;

abstract class Blade extends Component
{
    protected array $props = [];

    public function render(): Closure|string //View|Htmlable|Closure|string
    {
        if (
            $this->hasProp('if') &&
            $this->if === false
        ) {
            return '';
        }

        return fn ($data) => $this->output($data);
    }

    protected function output(array $data): View|Htmlable|string
    {
        $data = (object) $data;
        $viewPath = $this->componentViewPath();
        $class = $this->componentClass();
        $wireModel = $data->attributes->wire('model')->value();

        // Set livewire model variable
        if (($data->model ?? true) && $wireModel) {
            $data->model = $wireModel;
        }

        // Manipulate using custom traits (e.g. Translatable, Routable, etc.)
        if ($addAttributes = $this->triggerHelperTraits()) {
            $data->attributes = $data->attributes->merge(
                $addAttributes
            );
        }

        if (method_exists($class, 'blade')) {
            return $this->blade();
        }

        if (Str::startsWith($class, 'App\\View\\Components\\')) {
            return view($viewPath, $data)->render();
        }

        return Tall::view($viewPath, $data)->render();

    }

    protected function componentViewPath(): string
    {
        if (method_exists($class = $this->componentClass(), 'render')) {
            return null;
        }

        $viewPath = $class;
        $propertyName = 'componentViewPath';

        // Allow overriding view path from child class
        if ($this->hasProp($propertyName)) {
            return $this->$propertyName;
        }

        // App\View\Modal\ModalHeader -> ['modal', 'modal-header'] -> modal.modal-header
        $viewPath = Str::remove('App\\View\\Components\\', $viewPath);
        $viewPath = Str::remove('Ja\\Livewire\\Blade\\', $viewPath);
        $viewPath = (
            collect(explode('\\', $viewPath))
                ->map(fn ($slug) => Str::snake($slug, '-'))
                ->join('.')
        );

        return "components.{$viewPath}";
    }

    protected function componentClass(): string
    {
        return get_called_class();
    }

    private function triggerHelperTraits(array $attributes)
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
                ->map(function ($trait) use ($attributes) {
                    $get = "get{$trait}";
                    return $this->$get($attributes);
                })
                ->collapse()
                ->all()
        );
    }

    private function hasProp(string $propertyName): bool
    {
        return $this->hasProp($propertyName);
    }

    /**
     * Wrapper for componentHasTrait
     *
     * @return boolean
     */
    protected function hasTrait(string $trait): bool
    {
        $class = $this->componentClass();

        return (
            TallBlade::componentHasTrait($class, $trait) ||
            TallBlade::componentHasTrait(get_parent_class($class), $trait)
        );
    }
}
