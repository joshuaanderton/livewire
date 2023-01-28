<div>
    @if ($label)
        <x-jal::label :text="$label" />
    @endif

    <div
        wire:ignore
        class="{{ $label ? 'mt-1' : '' }} w-full"
        x-data="{
            multiple: true,
            value: $wire.get('{{ $model }}'),
            options: [
                @foreach($options as $val => $option)
                { value: {{ $val }}, label: '{{ $option }}' },
                @endforeach
            ],
            init() {
                this.$nextTick(() => {

                    const addItems = $refs.select.tagName === 'INPUT'

                    let options = {
                        removeItems: true,
                        removeItemButton: true,
                    }

                    if (addItems) {
                        options.addItems = true
                    }

                    let choices = new Choices(this.$refs.select, options)
    
                    let refreshChoices = () => {
                        let selection = this.multiple ? this.value : [this.value]
    
                        choices.clearStore()
                        choices.setChoices(this.options.map(({ value, label }) => ({
                            value,
                            label,
                            selected: selection.includes(value),
                        })))
                    }
    
                    this.$refs.select.addEventListener('change', () => {
                        this.value = choices.getValue(true)
                        $wire.set('{{ $model }}', this.value)
                    })
    
                    if (addItems) return

                    refreshChoices()
    
                    this.$watch('value', () => refreshChoices())
                    this.$watch('options', () => refreshChoices())
                })
            }
        }"
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
        <div class="text-xs text-red-500 mt-1">
            {{ $message }}
        </div>
    @enderror
</div>