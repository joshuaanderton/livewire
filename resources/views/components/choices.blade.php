<div>
    @if ($label)
        <x-label :text="$label" />
    @endif

    <div
        wire:ignore
        class="{{ $label ? 'mt-1' : '' }} w-full"
        x-data="{
            values: $wire.get('{{ $model }}'),
            options: @js($options),
            getOptions() {
                return Object.entries(this.options).map(([value, label]) => ({
                    value,
                    label,
                    selected: this.values.includes(parseInt(value)),
                }))
            },
            init() {
                this.$nextTick(() => {

                    const addItems = this.$refs.element.tagName === 'INPUT',
                          instance = new Choices(this.$refs.element, {
                              addItems,
                              removeItems: true,
                              removeItemButton: true,
                          })

                    if (addItems) {
                        instance.setValue(
                            this.options.length === 0
                                ? object.values(this.value)
                                : this.getOptions().filter(opt => opt.selected).map(opt => opt.label)
                        )
                        return
                    }

                    instance.setChoices(
                        this.getOptions()
                    )
                })
            }
        }"
    >
        @if ($addItems)
            <input {{ $attributes->merge([
                'x-ref' => 'element',
                'type' => 'hidden',
            ]) }} />
        @else
            <select {{ $attributes->merge([
                'x-ref' => 'element',
                'type' => null,
                'multiple' => true,
                'multiselect' => true,
            ]) }}></select>
        @endif
    </div>

    @error($model)
        <div class="text-xs text-red-500 mt-1">
            {{ $message }}
        </div>
    @enderror

</div>