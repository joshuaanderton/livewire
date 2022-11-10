<div>
    @if ($label)
        <x-label :text="$label" />
    @endif

    <div
        wire:ignore
        class="{{ $label ? 'mt-1' : '' }} max-w-sm w-full"
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
                    let choices = new Choices(this.$refs.select, {
                        classNames: {
                            //containerOuter: 'choices',
                            containerInner: 'choices__inner border-none bg-transparent focus:outline-none focus:ring-transparent p-0',
                            input: 'choices__input',
                            //inputCloned: 'choices__input--cloned',
                            //list: 'choices__list',
                            //listItems: 'choices__list--multiple',
                            //listSingle: 'choices__list--single',
                            //listDropdown: 'choices__list--dropdown',
                            //item: 'choices__item',
                            //itemSelectable: 'choices__item--selectable',
                            //itemDisabled: 'choices__item--disabled',
                            //itemChoice: 'choices__item--choice',
                            //placeholder: 'choices__placeholder',
                            //group: 'choices__group',
                            //groupHeading: 'choices__heading',
                            //button: 'choices__button',
                            //activeState: 'is-active',
                            //focusState: 'is-focused',
                            //openState: 'is-open',
                            //disabledState: 'is-disabled',
                            //highlightedState: 'is-highlighted',
                            //selectedState: 'is-selected',
                            //flippedState: 'is-flipped',
                            //loadingState: 'is-loading',
                            //noResults: 'has-no-results',
                            //noChoices: 'has-no-choices'
                        }
                    })

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