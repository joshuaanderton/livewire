<div>
    @if ($label)
        <x-jal::label :text="$label" :required="$required" />
    @endif

    <div
        wire:ignore
        class="{{ $label ? 'mt-1' : '' }} w-full"
        x-data="jalChoices({
            model: @js($model),
            options: @js($options)
        })"
        class="max-w-sm w-full"
    >
        @if ($addItems)
            <input {{ $attributes->merge(['x-ref' => 'select', 'type' => 'hidden']) }} />
        @else
            <select {{ $attributes->merge([
                'x-ref' => 'select',
                'type' => null,
                'multiple' => true,
                'multiselect' => true,
                'disabled' => null,
            ]) }}></select>
        @endif
    </div>

    @error($model)
        <x-input.error :model="$model" />
    @enderror
</div>