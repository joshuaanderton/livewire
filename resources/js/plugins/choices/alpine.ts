import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.min.css'
import './styles.css'

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
  value: string|number
}

interface Data {
  model: string
  multiple: boolean
  options: Option[]
  value: string|number|string[]|number[]|null
  init: () => void
}

export const data = ({
  model,
  options = [],
  multiple = true
}: Props): Data => ({

  model,

  multiple,

  get options(): Option[] {
    return (
      Object
        .values(options)
        .map(({ label, value }: any): Option => ({ label, value }))
    )
  },

  get value() {
    return this.$wire.get(model)
  },

  set value(newValue) {
    this.$wire.set(model, newValue)
  },

  init() {

    this.$nextTick(() => {

      const input = this.$refs.select,
            addItems = input.tagName === 'INPUT'

      let config: ChoicesConfig = {
        removeItems: true,
        removeItemButton: true,
      }

      if (addItems) {
        config.addItems = true
      }

      let choices = new Choices(input, config)

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

      input.addEventListener('change', () => {
        this.value = choices.getValue(true)
      })

      if (addItems) return

      refreshChoices()

      this.$watch('value', () => refreshChoices())
      this.$watch('options', () => refreshChoices())
    })
  }
})