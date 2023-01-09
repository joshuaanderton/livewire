<?php

namespace Ja\Livewire\Blade;

use Ja\Livewire\Blade\Traits\Routable;
use Ja\Livewire\Blade\Traits\Translatable;
use Ja\Livewire\Blade as Component;

class Link extends Component
{
    use Routable, Translatable;
    
    protected array $translatable = ['text'];

    public string $href;

    public ?string $text;

    public bool $if;

    public function __construct(
        string $href = null,
        string|array $route = null,
        string $text = null,
        bool $if = null
    ) {
        if (! $href && $route) :
            $href = $this->route($route);
        endif;

        $this->href = $href;
        $this->text = $text;
        $this->if = $if === null ? true : $if;
    }

    public function render()
    {
        if (! $this->if) {
            return '';
        }

        return <<<'blade'
            <a {{ $attributes->merge(compact('href')) }}>{{ $text }}{{ $slot }}</a>
        blade;
    }
}
