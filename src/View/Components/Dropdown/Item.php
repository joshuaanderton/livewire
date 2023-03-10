<?php declare (strict_types=1);

namespace LivewireKit\View\Components\Dropdown;

use LivewireKit\Blade as Component;
use LivewireKit\View\Traits\Routable;
use LivewireKit\View\Traits\Translatable;

class Item extends Component
{
    use Routable;
    use Translatable;

    protected array $translatable = ['text'];

    public string $tag;

    public ?string $type;

    public ?string $href;

    public ?string $text;

    public ?string $icon;

    public ?string $iconType;

    public function __construct(
        string $href = null,
        array|string $route = null,
        string $text = null,
        string $type = null,
        string $icon = null,
        string $iconType = null
    ) {
        if (! $href && $route) {
            $href = $this->route($route);
        }

        $this->href = $href;
        $this->tag = $this->href ? 'a' : 'button';
        $this->type = $type ?: ($this->tag === 'button' ? 'button' : null);
        $this->text = $text;
        $this->icon = $icon;
        $this->iconType = $iconType;
    }
}
