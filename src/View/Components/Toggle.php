<?php declare (strict_types=1);

namespace LivewireKit\View\Components;

use LivewireKit\Blade as Component;
use LivewireKit\View\Traits\Mergeable;
use LivewireKit\View\Traits\Translatable;

class Toggle extends Component
{
    use Mergeable,
        Translatable;

    protected array $translatable = ['label'];

    public ?string $label;

    public bool $right;

    public ?string $wrapperClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label = null, bool $right = null, array $props = null, string $wrapperClass = null)
    {
        $this->label = $label;
        $this->right = !! $right;
        $this->wrapperClass = $wrapperClass;
        $this->props = $props ?: [];
    }
}
