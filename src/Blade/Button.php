<?php

namespace Ja\Tall\Blade;

use Illuminate\Support\Facades\Auth;
use Ja\Tall\Blade\Traits\Mergeable;
use Ja\Tall\Blade\Traits\CssClassable;
use Ja\Tall\Blade\Traits\Routable;
use Ja\Tall\Blade\Traits\Translatable;
use Ja\Tall\Blade as Component;

class Button extends Component
{
    use CssClassable,
        Routable,
        Mergeable,
        Translatable;

    protected array $mergeable = ['props'];

    protected array $translatable = ['text'];

    protected array $routable = ['route'];

    public string $tag = 'button';

    public ?string $text, $icon, $href;

    public bool $if;

    public string|array|null $class;

    protected array $cssClasses = [
        'group',
        'relative',
        'inline-flex',
        'items-center',
        'justify-center',
        'space-x-1',
        'whitespace-nowrap',
        'font-medium',
        'shadow-sm',
        'rounded-md',
        'border',
        'focus:outline-none',
        'focus:ring-2',
        'leading-5',
        'text-sm',
        'px-4',
        'py-2',
        'transition-all',
    ];

    protected string|array $variantCssClasses = [
        'border-transparent',
        'text-white',
        'focus:ring-primary-500',
        'bg-primary-600',
        'hover:bg-primary-700',
        'dark:bg-primary-500',
        'dark:hover:bg-primary-600',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $text = null,
        string|array $route = null,
        string $href = null,
        string $icon = null,
        string|array $class = null,
        string $permitted = null,
        bool $if = null,
        array $props = null
    )
    {
        $this->text  = $text;
        $this->icon  = $icon;
        $this->class = $class;
        $this->href  = $href;
        $this->if    = $if === null ? true : $if;
        $this->props = $props ?: [];

        if ($permitted) {
            $this->if = Auth::check() && Auth::user()->permitted($permitted);
        }

        // Add variant class names to default ones (e.g. for <x-button.outline /> variant)
        $this->cssClasses = array_merge(
            $this->cssClasses,
            $this->variantCssClasses
        );

        if (! $this->href && $route) :
            $this->href = $this->route($route);
        endif;

        if ($this->href) {
            $this->tag = 'a';
        }
    }
}