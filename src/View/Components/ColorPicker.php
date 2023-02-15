<?php declare (strict_types=1);

namespace Ja\Livewire\View\Components;

use Ja\Livewire\Blade as Component;

class ColorPicker extends Component
{
    public ?string $label;

    public string $wrapperClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label = null, string $wrapperClass = null)
    {
        $this->label = $label;
        $this->wrapperClass = $wrapperClass ?: '';
    }
}
