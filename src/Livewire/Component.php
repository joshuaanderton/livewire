<?php

namespace Ja\Tall\Livewire;

use Livewire\Component as LivewireComponent;

class Component extends LivewireComponent
{
    private function getComponentNamespaceProperty()
    {
        return get_called_class();
    }

    private function getComponentViewPathProperty()
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