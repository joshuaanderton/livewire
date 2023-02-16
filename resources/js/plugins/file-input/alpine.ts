import { upperFirst } from '@pckg/lodash'

interface File {
  name?: string
  type?: string
  size?: string
  preview: string
}

interface Data {
  model?: string
  files: File[]
  multiple: boolean
  formatFileSize: (size: number) => string
  updateFiles: (event: {target: {files: File[]}}) => void
  preview: string|null
  hasFiles: boolean
  open: () => void
  clear: () => void
  init: () => void
}

export const data = (): Data => ({
  
  model: undefined,
  
  files: [],
  
  multiple: false,

  formatFileSize(size) {

    let suffix = 'KB'

    if (size > 1000) {
      size = size / 1000
      suffix = 'MB'
    }
    
    if (size > 1000) {
      size = size / 1000
      suffix = 'GB'
    }
    
    if (size > 1000) {
      size = size / 1000
      suffix = 'TB'
    }

    if (size % 1 !== 0) {
      return `${parseFloat(String(size)).toFixed(1)} ${suffix}`
    }

    return `${size} ${suffix}`
  },

  updateFiles(event) {
    this.files = []

    Array.from(event.target.files).map(file => this.files.push({
      name: file.name,
      type: file.type,
      size: this.formatFileSize(file.size),
      preview: URL.createObjectURL(file as any)
    }))

    if (!this.multiple) {
      const freeMemory = event => {
        URL.revokeObjectURL(event.target.src)
        event.target.removeEventListener('onload', freeMemory)
      }
      this.$refs.image.addEventListener('onload', freeMemory)
    }
  },

  get hasFiles() {
    return this.files.length > 0
  },

  get preview() {
    return this.hasFiles
      ? this.files[0].preview
      : null
  },

  open() {
    this.$refs.input.click()
  },

  clear() {
    this.$refs.input.value = null
    this.files = []
    this.$wire.set(this.model, null);
    this.$wire.set(`delete${upperFirst(this.model)}`, true);
  },

  init() {
    this.model = this.$refs.input.getAttribute('wire:model')
    this.multiple = this.$refs.input.multiple

    if (!this.multiple && this.$refs.input.defaultValue) {
      this.files.push({preview: this.$refs.input.defaultValue})
    }
  }
})