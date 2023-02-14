<x-jal::input-group
    :label="$label"
    :disclaimer="$disclaimer ?? $attributes['disclaimer'] ?? null"
    :disabled="$disabled ?? $attributes['disabled'] ?? null"
    :required="$required ?? $attributes['required'] ?? null"
>

    <div class="relative rounded-md shadow-sm font-base">
        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5">
            <x-icon name="calendar-solid" class="text-gray-400" />
        </div>

        <div wire:ignore x-data="jalFlatpickr" x-cloak>
            <input wire:ignore {{ $attributes->merge([
                'x-ref'       => 'picker',
                'type'        => 'date',
                'class'       => $class,
                'placeholder' => $placeholder,
            ]) }} />
        </div>
    </div>

</x-jal::input-group>