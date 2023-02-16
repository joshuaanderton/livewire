import { data } from './alpine'
import '@pckg/choices.js/public/assets/styles/choices.min.css'
import './styles.css'
import { config } from '../../utils'

document.addEventListener('alpine:init', () => (
  [
    // Default name
    'jalChoices',
    
    // Allow for custom name (e.g. "choices" -> x-data="choices")
    config().plugins?.choices?.name

  ].filter(k => k !== undefined).forEach(key => (
    (window as any).Alpine.data(key, data)
  ))
))