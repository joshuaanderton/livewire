<?php declare (strict_types=1);

namespace LivewireKit\View\Components;

use LivewireKit\View\Traits\Mergeable;
use LivewireKit\View\Traits\Translatable;
use LivewireKit\Blade as Component;

class FileInput extends Component
{
    use Mergeable;
    use Translatable;

    protected $translatable = ['label'];

    public ?string $label;

    public ?string $icon;

    public bool $required;

    public array $files;

    public ?string $emptyState;

    public ?string $wrapperClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $icon = null,
        ?bool $required = null,
        ?array $props = null,
        ?array $files = null,
        ?string $emptyState = null,
        ?string $wrapperClass = null,
    ) {
        $this->label = $label;
        $this->icon = $icon;
        $this->required = ! ! $required;
        $this->props = $props ?: [];
        $this->files = $files ?: [];
        $this->emptyState = $emptyState;
        $this->wrapperClass = $wrapperClass;
    }
}
