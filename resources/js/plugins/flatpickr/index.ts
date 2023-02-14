import { data } from './alpine'
import 'flatpickr/dist/flatpickr.min.css'
import './styles.css'
import { config } from '../../utils'

document.addEventListener('alpine:init', () => (
  [
    // Default name
    'jalFlatpickr',
    
    // Allow for custom name (e.g. "flatpickr" -> x-data="flatpickr")
    config().plugins?.flatpickr?.name

  ].filter(k => k !== undefined).forEach(key => (
    (window as any).Alpine.data(key, data)
  ))
))