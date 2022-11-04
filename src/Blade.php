<?php

namespace Ja\Tall;

use Closure;
use Ja\Tall\Support\Blade as TallBlade;
use Ja\Tall\Blade\Traits\WithMergeAttributes;
use Ja\Tall\Blade\Traits\WithDefaultCssClasses;
use Ja\Tall\Blade\Traits\WithTranslateAttributes;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Blade extends Component
{
    /**
     * Define a list of properties that should not be passed to view
     *
     * @return array
     */
    public $except = [
        'except',
        'mergeable',
        'mergeClassNames',
        'hasProperty',
    ];

    public function __construct()
    {
        //
    }

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

        $viewPath = get_called_class();                                            // App\View\Components\Modals\ModalHeader (example)
        $viewPath = Str::remove('App\\View\\Components\\', $viewPath);             // Modals\ModalHeader
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

        $addAttributes = $this->getMergeableAttributes();

        return function ($data) use ($addAttributes) {

            if (count($addAttributes) > 0) {
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

            return view("components.{$this->componentViewPath()}", $data)->render();
        };
    }

    /**
     * Checks for our custom trait (e.g. WithMergeAttributes),
     * sets neccessary class properties,
     * returns neccessary attributes for passing to view
     *
     * @return array
     */
    private function getMergeableAttributes()
    {
        $addAttributes = [];

        if ($this->hasTrait(WithMergeAttributes::class)) {
            $addAttributes = array_merge($addAttributes, $this->mergeAttributes());
        }

        if ($this->hasTrait(WithTranslateAttributes::class)) {
            $addAttributes = array_merge($addAttributes, $this->translateAttributes());
        }

        if ($this->hasTrait(WithDefaultCssClasses::class)) {
            $addAttributes = array_merge($addAttributes, $this->mergeClassNames());
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
