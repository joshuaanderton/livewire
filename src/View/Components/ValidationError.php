<?php declare (strict_types=1);

namespace LivewireKit\View\Components;

use LivewireKit\Blade as Component;

class ValidationError extends Component
{
    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return <<<'blade'
            <div {{ $attributes->merge(['class' => 'py-1 text-red-500 text-[.65rem]']) }}>
                {{ $message }}
            </div>
        blade;
    }
}
