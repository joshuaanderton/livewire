<?php

namespace Ja\Livewire\Blade;

use Illuminate\Support\Str;
use Ja\Livewire\Blade as Component;

class Dropdown extends Component
{
    public ?string $xShow;

    public ?string $button;

    public string $class;

    public bool $left;

    protected array $cssClasses = [
        'relative',
        'inline-block',
        'text-left'
    ];

    public string|array $menuCssClasses = [
        'mt-2',
        'absolute',
        'z-10',
        'w-56',
        'rounded-md',
        'bg-white',
        'shadow-lg',
        'ring-1',
        'ring-black',
        'ring-opacity-5',
        'focus:outline-none'
    ];

    public string|array $buttonCssClasses = [
        'inline-flex',
        'w-full',
        'justify-center',
        'rounded-md',
        'border',
        'border-gray-300',
        'bg-white',
        'px-4',
        'py-2',
        'text-sm',
        'font-medium',
        'text-gray-700',
        'shadow-sm',
        'hover:bg-gray-50',
        'focus:outline-none',
        'focus:ring-2',
        'focus:ring-black',
        'focus:ring-offset-2',
        'focus:ring-offset-gray-100'
    ];

    public function __construct(string $xShow = null, string $class = null, string $button = null, bool $left = null)
    {
        $this->xShow = $xShow ? Str::replace(' ', '-', trim($xShow)) : null;
        $this->class = $class ?: '';
        $this->button = $button;
        $this->left = !! $left;

        $this->except = array_merge($this->except ?? [], [
            'left'
        ]);

        $this->setCssClasses();
    }

    private function setCssClasses(): void
    {
        $this->class = (
            collect(array_merge($this->cssClasses, explode(' ', $this->class)))
                ->filter(fn ($class) => !empty($class))
                ->unique()
                ->join(' ')
        );

        $menuCssClasses = collect($this->menuCssClasses);
        
        if ($this->left) {
            $menuCssClasses->concat(['origin-top-left', 'left-0']);
        } else {
            $menuCssClasses->concat(['origin-top-right', 'right-0']);
        }

        $this->menuCssClasses = $menuCssClasses->join(' ');

        $this->buttonCssClasses = collect($this->buttonCssClasses)->join(' ');
    }
}
