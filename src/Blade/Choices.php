<?php

namespace Ja\Livewire\Blade;

use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\Translatable;
use Ja\Livewire\Blade as Component;

class Choices extends Component
{
    use Translatable,
        Mergeable;

    public array $options;

    public ?string $label;

    protected array $translatable = ['label'];

    public bool $addItems;

    public array $props;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array $options = null,
        string $label = null,
        bool $addItems = null,
        array $props = null
    )
    {
        $this->options = $options ?: [];
        $this->label = $label;
        $this->addItems = !! $addItems;
        $this->props = $props ?: [];
    }
}
