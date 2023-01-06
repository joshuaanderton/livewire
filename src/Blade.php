<?php

namespace Ja\Livewire;

use Closure;
use Exception;
use Ja\Livewire\Support\Blade as TallBlade;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\CssClassable;
use Ja\Livewire\Blade\Traits\Translatable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;
use Ja\Livewire\Support\Helper as Tall;

class Blade extends Component
{
    protected array $props;

    // public function __construct(...$props)
    // {
    //     $this->props = $props;
    // }

    /**
     * Automatically get the component's view path
     *
     * @return string
     */
    protected function componentViewPath(): string
    {
        // Allow overriding view path from child class
        if ($this->componentViewPath ?? false) {
            return $this->componentViewPath;
        }

        // TODO: Return null if $componentClass has render() method defined

        $componentClass = get_called_class();
        $baseComponentsNamespace = 'App\\View\\Components';

        if (Str::contains($componentClass, self::class)) {
            $baseComponentsNamespace = self::class;
        }

        $viewPath = $componentClass;                                               // Ja\Livewire\Blade as Components\Modals\ModalHeader (example)
        $viewPath = Str::remove("{$baseComponentsNamespace}\\", $viewPath);        // Modals\ModalHeader
        $viewPath = explode('\\', $viewPath);                                      // ['Modals', 'ModalHeader']
        $viewPath = collect($viewPath)->map(fn ($slug) => Str::snake($slug, '-')); // ['modals', 'modal-header']
        $viewPath = $viewPath->join('.');                                          // modals.modal-header

        return $viewPath;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (($this->if ?? null) === false) {
            return '';
        }

        // $props = $this->props;
        // return $this->render(...$props);

        $addAttributes = $this->getMergeAttributes();

        return function ($data) use ($addAttributes) {

            if ($addAttributes) {
                $data['attributes'] = $data['attributes']->merge(
                    $addAttributes
                );
            }

            if (
                !isset($data['model']) &&
                $wireModel = $data['attributes']->wire('model')->value()
            ) {
                $data['model'] = $wireModel;
            }

            return Tall::view("components.{$this->componentViewPath()}", $data)->render();

        };
    }

    /**
     * Checks for our custom trait (e.g. Mergeable),
     * sets neccessary class properties,
     * returns neccessary attributes for passing to view
     *
     * @return array
     */
    private function getMergeAttributes()
    {
        $addAttributes = [];

        if ($this->hasTrait(Mergeable::class)) {
            $addAttributes = array_merge($addAttributes, $this->getMergeable());
        }

        if ($this->hasTrait(CssClassable::class)) {
            $addAttributes = array_merge($addAttributes, $this->getCssClassable());
        }

        if ($this->hasTrait(Translatable::class)) {
            $addAttributes = array_merge($addAttributes, $this->getTranslatable());
        }

        return $addAttributes;
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
