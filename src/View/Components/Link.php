<?php declare (strict_types=1);

namespace LivewireKit\View\Components;

use LivewireKit\Blade as Component;
use LivewireKit\View\Traits\Routable;
use LivewireKit\View\Traits\Translatable;

class Link extends Component
{
    use Routable;
    use Translatable;

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
}
