<?php

namespace TallStackApp\Tools\Blade;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use TallStackApp\Tools\Blade\Traits\Mergeable;
use TallStackApp\Tools\Blade\Traits\CssClassable;
use TallStackApp\Tools\Blade\Traits\Routable;
use TallStackApp\Tools\Blade\Traits\Translatable;
use TallStackApp\Tools\Blade as Component;

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

    protected bool $xs;

    protected bool $sm;

    protected bool $md;

    protected bool $lg;

    protected bool $neutral;

    protected bool $danger;

    protected bool $secondary;

    protected bool $outline;

    protected bool $border;

    public bool $confirm;

    public string $confirmText;

    public array $sizeCssClasses = [
        'xs' => [
            'rounded',
            'px-1.5',
            'py-1',
            'text-xs',
        ],
        'sm' => [
            'rounded',
            'px-2.5',
            'py-1.5',
            'text-xs',
        ],
        'base' => [
            'rounded-md',
            'px-3',
            'py-2',
            'text-sm',
            'leading-4',
        ],
        'md' => [
            'rounded-md',
            'px-4',
            'py-2',
            'text-sm',
        ],
        'lg' => [
            'rounded-md',
            'px-4',
            'py-2',
            'text-base',
        ],
        'xl' => [
            'rounded-md',
            'px-6',
            'py-3',
            'text-base',
        ]
    ];

    protected array $cssClasses = [
        'relative',
        'group',
        'inline-flex',
        'items-center',
        'justify-center',
        'space-x-2',
        'whitespace-nowrap',
        'font-medium',
        'border',
        'transition-all',
        'focus:outline-none',
        'focus:ring-2',
        'focus:ring-offset-2',
    ];

    protected string|array $variantCssClasses = [
        'default' => [
            'primary' => [
                'shadow-sm',
                'border-transparent',
                'text-white',
                'focus:ring-theme-600',
                'bg-theme-600',
                'hover:bg-theme-700',
                'focus:ring-theme-600',
            ],
            'secondary' => [
                'border-transparent',
                'bg-theme-200',
                'text-theme-700',
                'hover:bg-theme-200',
                'focus:ring-theme-600',
            ],
            'outline' => [
                'text-theme-700',
                'border-theme-200',
                'bg-white',
                'hover:bg-theme-50',
                'focus:ring-theme-600',
            ]
        ],
        'neutral' => [
            'primary' => [
                'shadow-sm',
                'border-transparent',
                'text-white',
                'bg-neutral-600',
                'hover:bg-neutral-700',
                'focus:ring-theme-600',
            ],
            'secondary' => [
                'border-transparent',
                'bg-neutral-200',
                'text-neutral-700',
                'hover:bg-neutral-200',
                'focus:ring-theme-600',
            ],
            'outline' => [
                'text-neutral-700',
                'border-neutral-200',
                'bg-white',
                'hover:bg-neutral-50',
                'focus:ring-theme-600',
            ]
        ],
        'danger' => [
            'primary' => [
                'shadow-sm',
                'border-transparent',
                'text-white',
                'bg-red-600',
                'hover:bg-red-700',
                'focus:ring-red-600',
            ],
            'secondary' => [
                'border-transparent',
                'bg-red-200',
                'text-red-700',
                'hover:bg-red-200',
                'focus:ring-red-600',
            ],
            'outline' => [
                'text-red-700',
                'border-red-200',
                'bg-white',
                'hover:bg-red-50',
                'focus:ring-red-600',
            ]
        ],
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
        bool $if = null,
        array $props = null,
        bool $confirm = null,
        string $confirmText = null,
        bool $xs = null,
        bool $sm = null,
        bool $md = null,
        bool $lg = null,
        bool $neutral = null,
        bool $danger = null,
        bool $secondary = null,
        bool $outline = null,
        bool $border = null
    )
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->class = $class;
        $this->href = $href;
        $this->if = $if === null ? true : $if;
        $this->props = $props ?: [];
        $this->xs = !! $xs;
        $this->sm = !! $sm;
        $this->md = !! $md;
        $this->lg = !! $lg;
        $this->neutral = !! $neutral;
        $this->danger = !! $danger;
        $this->secondary = !! $secondary;
        $this->outline = !! $outline;
        $this->border = $border === null ? true : $border;
        $this->confirm = !! $confirm;
        $this->confirmText = $confirmText ?: (Lang::has('components.are_you_sure') ? __('components.are_you_sure') : __('tall::components.are_you_sure'));

        if (! $this->href && $route) :
            $this->href = $this->route($route);
        endif;

        if ($this->href) {
            $this->tag = 'a';
        }

        $this->setCssClasses();
    }

    private function setCssClasses()
    {
        $size = 'base';

        if ($this->xs) {
            $size = 'xs';
        } elseif ($this->sm) {
            $size = 'sm';
        } elseif ($this->md) {
            $size = 'md';
        } elseif ($this->lg) {
            $size = 'lg';
        }

        $variant = 'primary';

        if ($this->secondary) {
            $variant = 'secondary';
        } elseif ($this->outline) {
            $variant = 'outline';
        }

        $theme = 'default';

        if ($this->neutral) {
            $theme = 'neutral';
        } elseif ($this->danger) {
            $theme = 'danger';
        }

        $this->cssClasses = array_merge(
            $this->cssClasses,
            $this->sizeCssClasses[$size],
            $this->variantCssClasses[$theme][$variant]
        );

        if (!$this->border) {
            $this->cssClasses = collect($this->cssClasses)->filter(fn ($class) => !Str::contains($class, 'border-'))->all();
            $this->cssClasses[] = 'border border-transparent';
        }
    }
}