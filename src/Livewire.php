<?php

namespace Ja\Tall;

use Livewire\Component as LivewireComponent;

class Livewire extends LivewireComponent
{
    protected function getComponentNamespaceProperty()
    {
        return get_called_class();
    }

    protected function getComponentViewPathProperty()
    {
        $componentClass = $this->componentNamespace;
        $componentPath  = explode('Http\\Livewire\\', $componentClass)[0];
        $componentPath  = collect(explode('\\', $componentPath))
                            ->map(fn ($s) => Str::snake($s, '-'))
                            ->join('.');

        return $componentPath;
    }

    public function render()
    {
        return view($this->componentViewPath);
    }
}