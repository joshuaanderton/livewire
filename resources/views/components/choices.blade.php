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
            init() {
                this.$nextTick(() => {
                    
                    let choices,
                        options = {
                            removeItems: true,
                            removeItemButton: true,
                            addItems: true
                        }
                    
                    const canAddItems = (this.$refs.input.dataset.addItems || null) === 'true',
                          refreshChoices = () => {
                              choices.clearStore()
                              choices.setChoices(Object.entries(this.options).map(([value, label]) => ({
                                  value,
                                  label,
                                  selected: this.values.includes(parseInt(value)),
                              })))
                          }

                    if (canAddItems) {
                        choices = new Choices(this.$refs.input, {
                            ...options,
                            addItems: true
                        })
                    } else {
                        choices = new Choices(this.$refs.input, options)
    
                        refreshChoices()
                        this.$watch('values', () => refreshChoices())
                        this.$watch('options', () => refreshChoices())
                    }

                    this.$refs.input.addEventListener('change', () => {
                        $wire.set('{{ $model }}', choices.getValue(true))
                    })
                })
            }
        }"
    >
        @if ($attributes['data-add-items'] == 'true')
            <input {{ $attributes->merge(['x-ref' => 'input']) }} />
        @else
            <select {{ $attributes->merge(['x-ref' => 'input', 'multiple' => true, 'multiselect' => true, 'type' => null]) }}></select>
        @endif
    </div>

    @if ($model = $attributes->wire('model')->value())
        @error($model)
            <div class="text-xs text-red-500 mt-1">
                {{ $message }}
            </div>
        @enderror
    @endif

</div>