<?php

namespace Ja\Tall\Blade;

use Ja\Tall\Blade\Traits\Mergeable;
use Ja\Tall\Blade\Traits\Translatable;
use Ja\Tall\Blade as Component;

class Choices extends Component
{
    use Translatable,
        Mergeable;

    public array $options;

    public ?string $label;

    protected array $translatable = ['label'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array $options = null,
        string $label = null,
        array $props = null
    )
    {
        $this->options = $options ?: [];
        $this->label = $label;
        $this->props = $props ?: [];
    }
}
