<?php

namespace Ja\View\Blade;

use Traits\WithRoute;
use Illuminate\Support\{ Str, Arr };

class Button extends Component
{
    use WithRoute;

    public ?string $icon, $iconType, $iconClass;
    public bool $iconXs, $iconSm, $iconLg;

    public ?string $tag, $href, $text;
    public string $class, $theme;
    public bool $secondary, $outline, $disabled, $active, $borderless, $circle, $xs, $sm, $lg;

    protected $defaultClasses = [
        'inline-flex', 
        'items-center', 
        'space-x-2',
        'font-medium', 
        'focus:outline-none', 
        'focus:ring-2', 
        'focus:ring-offset-2', 
        'border',
    ];

    protected $colorThemes = [
        'default' => [
            'bg-scholarpath-500',
            'hover:bg-scholarpath-700',
            'border-scholarpath-500',
            'hover:border-scholarpath-700',
            'focus:ring-scholarpath-500',
        ],
        'secondary' => [
            'text-scholarpath-700',
            'bg-scholarpath-100',
            'border-scholarpath-100',
            'hover:bg-scholarpath-200',
            'focus:ring-scholarpath-500',
        ],
        'outline' => [
            'text-scholarpath-700',
            'border-scholarpath-300',
            'hover:bg-scholarpath-50',
            'focus:ring-scholarpath-500', 
        ]
    ];

    public function __construct(
        string $tag = 'button', 
        string $class = '', 
        mixed $route = null, 
        string $href = null, 
        bool $secondary = null,
        bool $outline = null,
        bool $borderless = null,
        bool $disabled = null,
        bool $active = null,
        bool $circle = null,
        bool $xs = null,
        bool $sm = null,
        bool $lg = null,
        string $icon = null,
        string $iconType = null,
        string $iconClass = null,
        bool $iconXs = null,
        bool $iconSm = null,
        bool $iconLg = null,
        string $text = null
    ){
        $this->tag        = $tag;
        $this->route      = $route;
        $this->href       = $href;
        $this->class      = $class;
        $this->text       = $text ? __($text) : '';

        $this->borderless = !!$borderless;
        $this->disabled   = !!$disabled;
        $this->active     = !!$active;
        $this->outline    = $outline === true && $this->active ? false : !!$outline; // Turn off outline state if button is active
        $this->secondary  = !!$secondary;
        $this->theme      = $this->outline ? 'outline' : ($this->secondary ? 'secondary' : 'default');
        $this->circle     = !!$circle;
        $this->xs         = !!$xs;
        $this->sm         = !!$sm;
        $this->lg         = !!$lg;

        $this->icon       = $icon;
        $this->iconType   = $iconType;
        $this->iconClass  = $iconClass;
        $this->iconXs     = !!$iconXs;
        $this->iconSm     = !!$iconSm;
        $this->iconLg     = !!$iconLg;

        if (!($this->iconXs ?: $this->iconSm ?: $this->iconLg) && $this->xs ?: $this->sm) :
            $this->iconSm = true;
        endif;

        if ($this->route) :
            $this->href = $this->getRoutePath();
        endif;
        
        if ($this->href) :
            $this->tag = 'a';
        endif;
    }

    public function render()
    {
        // The only way to check if current component $slot->isEmpty()
        // is by returning a function (then can access it via $data array)
        return fn ($data) => (
            view('components.button', $this->mergeComponentData($data))->render()
        );
    }

    private function mergeComponentData(array $data): array
    {
        $data['wireTarget'] = (
            $data['attributes']->wire('target')->value() ?: 
            $data['attributes']->wire('click')->value()
        );
        
        $data['empty'] = (
            (is_null($data['text']) || empty(trim($data['text']))) &&
            $data['slot']->isEmpty()
        );

        $data['class'] = $this->cssClasses($data);

        $data['loadingClass'] = 'text-white';

        if ($this->theme !== 'default') :
            $data['iconClass'] = $data['loadingClass'] = $this->colorThemes[$this->theme][0];
        endif;

        return $data;
    }

    private function cssClasses(array $componentData): string
    {
        $cssClasses = ($componentData['class'] ?? false) ? explode(' ', $componentData['class']) : [];
        $theme = $this->theme;
        $empty = $componentData['empty'];

        $cssClasses = array_merge(
            $cssClasses,
            $this->colorThemes[$theme]
        );

        $cssClasses['min-w-[2.125rem]'] = $empty && $this->icon;

        if ($this->borderless) :
            $cssClasses = collect($cssClasses)->map(function($value, $key){ 
                return Str::of("{$value}{$key}")->contains('border-') 
                    ? null 
                    : $value;
            })->whereNotNull()->all();

            $cssClasses[] = 'border-transparent';
        endif;
        
        $cssClasses = array_merge($cssClasses, [
            'text-white' => $theme === 'default' && !$this->outline,
            'bg-white'   => $this->outline && !$this->borderless,
            'shadow-sm'  => !$this->borderless,
            'space-x-2'  => !!$this->icon,
        ]);

        if ($this->sm) :

            $cssClasses = array_merge($cssClasses, [
                'py-1.5',
                !$empty ? 'px-2.5' : 'px-1.5',
                'text-xs',
                $this->circle ? 'rounded-full' : 'rounded',
            ]);

        elseif ($this->xs) :

            $cssClasses = array_merge($cssClasses, [
                'py-1',
                !$empty ? 'px-1.5' : 'px-1',
                'text-xs',
                $this->circle ? 'rounded-full' : 'rounded',
            ]);
            
        elseif ($this->lg) :

            $cssClasses = array_merge($cssClasses, [
                'py-4',
                !$empty ? 'px-6' : 'px-4',
                'text-base',
                $this->circle ? 'rounded-full' : 'rounded-md',
            ]);
            
        else :

            $cssClasses = array_merge($cssClasses, [
                'py-2',
                !$empty ? 'px-4' : 'px-2',
                'text-sm',
                $this->circle ? 'rounded-full' : 'rounded-md',
            ]);

        endif;

        if (!Str::contains(Arr::toCssClasses($cssClasses), 'justify-')) :
            $cssClasses[] = 'justify-center';
        endif;
        
        if ($this->disabled) :
            $cssClasses = array_merge($cssClasses, [
                'cursor-not-allowed',
                'opacity-50'
            ]);
        endif;

        $cssClasses = array_merge(
            $this->defaultClasses,
            $cssClasses
        );

        if ($this->disabled || $this->active) :
            foreach($cssClasses as $i => $className) :
        
                if (Str::of($className)->contains([
                    'hover:',
                    'focus:',
                    'active:',
                    'group-hover:',
                    'transition'
                ])) :
                    unset($cssClasses[$i]);
                endif;
        
            endforeach;
        endif;

        return Arr::toCssClasses(
            $cssClasses
        );
    }
}