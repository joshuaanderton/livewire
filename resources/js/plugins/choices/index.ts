import alpineData from './alpine-data'
import '~/choices.js/public/assets/styles/choices.min.css'
import './styles.css'

export default () => (
  (window as any).Alpine.data('jalChoices', alpineData)
)