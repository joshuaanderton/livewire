import flatpickr from "flatpickr"

export interface FlatpickrOptions extends flatpickr.Options.Options {}

interface Data {
  options: {[key: string]: any}
  model?: string|null
  value?: string|number|null
  init: () => void
}

export const data = (options: FlatpickrOptions = {}): Data => ({
  
  options,
  
  model: undefined,
  
  value: undefined,

  init() {

    let input = this.$refs.input
    
    if (input === undefined) {
      input = this.$el.querySelector('input[type="date"]')
    }

    if (!input) {
      throw new Error('@ja-livewire: No date input found inside of flatpickr wrapper')
    }

    this.model = input.getAttribute('wire:model') || null

    this.value = (
      this.model
        ? this.$wire.get(this.model)
        : input.value
    ) || null

    const { defaultDate = this.value, ...options } = this.options

    const picker = flatpickr(input, {
      defaultDate,
      ...options
    })

    this.$watch('value', value => picker.setDate(value))
  },
})