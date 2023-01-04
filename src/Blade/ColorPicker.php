<?php

namespace TallStackApp\Tools\Blade;

use TallStackApp\Tools\Blade as Component;

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

    public function render()
    {
        return <<<'blade'
            <div
                class="{{ $wrapperClass }}"
                x-data="{
                    color: $wire.get('{{ $model = $attributes->wire('model')->value() }}'),
                    init() {
                        $watch('color', value => $wire.set('{{ $model }}', value))
                    }
                }"
            >
                @if ($label)
                    <x-tall::label :text="$label" />
                @endif
                <div class="relative">
                    <div class="rounded-l absolute inset-y-0 left-0 w-10 h-full hover:cursor-pointer z-10" :style="{ backgroundColor: color }">
                        <input type="color" x-model="color" class="absolute inset-0 opacity-0" />
                    </div>
                    <x-tall::input x-model="color" class="!pl-12" />
                </div>
            </div>
        blade;
    }
}