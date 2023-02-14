<?php declare (strict_types=1);

namespace Ja\Livewire\Blade;

use Ja\Livewire\Blade as Component;
use Ja\Livewire\Blade\Traits\CssClassable;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\Translatable;

class Checkbox extends Component
{
    use Translatable;
    use Mergeable;
    use CssClassable;

    protected array $translatable = ['label'];

    public ?string $label;

    protected array $cssClasses = [
        'h-4',
        'w-4',
        'border-gray-300',
        'rounded',
        'cursor-pointer',
        'text-primary-600',
        'focus:ring-primary-500',
        'dark:bg-gray-600',
        'dark:border-gray-500',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label = null, array $props = null)
    {
        $this->label = $label;
        $this->props = $props ?: [];
    }
}
