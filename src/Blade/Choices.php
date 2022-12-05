<?php

namespace TallStackApp\Tools\Blade;

use TallStackApp\Tools\Blade\Traits\Mergeable;
use TallStackApp\Tools\Blade\Traits\Translatable;
use TallStackApp\Tools\Blade as Component;

class Choices extends Component
{
    use Translatable,
        Mergeable;

    public array $options;

    public ?string $label;

    protected array $translatable = ['label'];

    public array $props;

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
