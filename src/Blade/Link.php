<?php

namespace TallStackApp\Tools\Blade;

use TallStackApp\Tools\Blade\Traits\Routable;
use TallStackApp\Tools\Blade as Component;
use TallStackApp\Tools\Blade\Traits\Translatable;

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
