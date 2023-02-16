import { data } from './alpine'
import { config } from '../../utils'

document.addEventListener('alpine:init', () => (
  [
    // Default name
    'jalFileInput',
    
    // Allow for custom name (e.g. "choices" -> x-data="choices")
    config().plugins?.choices?.name

  ].filter(k => k !== undefined).forEach(key => (
    (window as any).Alpine.data(key, data)
  ))
))