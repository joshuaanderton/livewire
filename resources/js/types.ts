export interface LivewireKitConfigPlugin {
  name?: string
}

export interface LivewireKitConfig {
  plugins?: {
    choices?: LivewireKitConfigPlugin
    flatpickr?: LivewireKitConfigPlugin
    fileInput?: LivewireKitConfigPlugin
  }
}