<div>
    @if ($label)
        <x-label :text="$label" />
    @endif

    <div
        wire:ignore
        class="{{ $label ? 'mt-1' : '' }} w-full"
        x-data="{
            multiple: true,
            value: $wire.get('{{ $model }}'),
            options: [
                @foreach ($options as $id => $title)
                    { value: '{{ $id }}', label: '{{ $title }}' },
                @endforeach
            ],
            init() {
                this.$nextTick(() => {
                    let choices = new Choices(this.$refs.select)

                    let refreshChoices = () => {
                        let selection = this.multiple ? this.value : [this.value]

                        choices.clearStore()
                        choices.setChoices(this.options.map(({ value, label }) => ({
                            value,
                            label,
                            selected: selection.includes(parseInt(value)),
                        })))
                    }

                    refreshChoices()

                    this.$refs.select.addEventListener('change', () => {
                        $wire.set('{{ $model }}', choices.getValue(true))
                    })

                    this.$watch('value', () => refreshChoices())
                    this.$watch('options', () => refreshChoices())
                })
            }
        }"
    >
        <select x-ref="select" :multiple="multiple"></select>
    </div>

</div>