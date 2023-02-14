export interface JaLivewireConfigPlugin {
  name?: string
}

export interface JaLivewireConfig {
  plugins?: {
    choices?: JaLivewireConfigPlugin
    flatpickr?: JaLivewireConfigPlugin
  }
}