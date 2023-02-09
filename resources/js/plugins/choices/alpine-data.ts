import Choices from '~/choices.js'

interface ChoicesConfig {
  removeItems: boolean
  removeItemButton: boolean
  addItems?: boolean
}

interface Props {
  model: string
  options?: Option[]
  multiple?: boolean
}

interface Option {
  label: string
  value: string
}

export default ({
  model,
  options = [],
  multiple = true
}: Props) => ({

  model,

  options,

  multiple,

  get value() {
    return this.$wire.get(model)
  },

  set value(newValue) {
    this.$wire.set(model, newValue)
  },

  init() {
    this.$nextTick(() => {

      const addItems = this.$refs.select.tagName === 'INPUT'

      let config: ChoicesConfig = {
        removeItems: true,
        removeItemButton: true,
      }

      if (addItems) {
        config.addItems = true
      }

      let choices = new Choices(this.refs.select, config)

      let refreshChoices = () => {
        const value = this.value

        let selection = this.multiple ? value : [value]

        if (!selection) {
          return
        }

        choices.clearStore()
        choices.setChoices(this.options.map(({ value, label }) => ({
          value,
          label,
          selected: selection.includes(value),
        })))
      }

      this.$refs.select.addEventListener('change', () => {
        this.value = choices.getValue(true)
      })

      if (addItems) return

      refreshChoices()

      this.$watch('value', () => refreshChoices())
      this.$watch('options', () => refreshChoices())
    })
  }
})