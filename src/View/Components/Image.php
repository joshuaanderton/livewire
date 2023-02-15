<?php

namespace Ja\Livewire\View\Components;

use Ja\Livewire\Blade as Component;

class Image extends Component
{
    public string $src;

    public bool $div;

    public ?string $class;

    public bool $if;

    public function __construct(
        string $src = null,
        ?bool $div = false,
        string $class = null,
        ?bool $if = true
    ) {
        $this->src = asset($src);
        $this->div = $div;
        $this->class = $class;
        $this->if = $if;

        $cssClasses = 'max-w-full h-auto inline-block';

        if ($this->div) {
            $cssClasses = 'bg-cover bg-center';
        }

        $this->class = "{$this->class} {$cssClasses}";
    }

    public function render()
    {
        if (! $this->if) return '';

        return <<<'blade'
            @if ($div)
                <div style="background-image: url('{{ $src }}')" {{ $attributes->merge([ 'class' => $class ]) }}></div>
            @else
                <img src="{{ $src }}" {{ $attributes->merge([ 'class' => $class ]) }} />
            @endif
        blade;
    }
}
