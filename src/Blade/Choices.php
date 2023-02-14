<?php declare (strict_types=1);

namespace Ja\Livewire\Blade;

use Ja\Livewire\Blade as Component;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\Translatable;

class Choices extends Component
{
    use Translatable;
    use Mergeable;

    public array $options;

    public ?string $label;

    protected array $translatable = ['label'];

    public bool $required;

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
        bool $required = null,
        bool $addItems = null,
        array $props = null
    ) {
        $this->options = $options ?: [];
        $this->label = $label;
        $this->required = ! ! $required;
        $this->addItems = ! ! $addItems;
        $this->props = $props ?: [];

        $options = $options ?: $this->props['options'] ?? [];
        $options = collect($options);

        if (isset($this->props['options'])) {
            unset($this->props['options']);
        }

        $this->options = (
            $options
                ->map(function ($label, $value) {
                    $value = ! is_numeric($value)
                        ? htmlspecialchars($value) :
                        (int) $value;

                    $label = htmlspecialchars((string) $label);

                    return compact('value', 'label');
                })
                ->all()
        );
    }
}
