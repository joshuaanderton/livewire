<?php declare (strict_types=1);

namespace Ja\Livewire\Blade;

use Ja\Livewire\Blade as Component;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\Translatable;

class InputGroup extends Component
{
    use Mergeable,
        Translatable;

    protected $translatable = ['label', 'disclaimer'];

    public bool $disabled,
                $required;

    public ?string $for,
                   $label,
                   $disclaimer,
                   $icon,
                   $iconType,
                   $prepend;

    public function __construct(
        string $disabled = null,
        string $required = null,
        string $for = null,
        string $label = null,
        string $disclaimer = null,
        string $icon = null,
        string $iconType = null,
        string $prepend = null,
    ) {
        $this->disabled = !! $disabled;
        $this->required = !! $required;
        $this->for = $for;
        $this->label = $label;
        $this->disclaimer = $disclaimer;
        $this->icon = $icon;
        $this->iconType = $iconType;
        $this->prepend = $prepend;
    }
}
