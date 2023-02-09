import { JaLivewireConfig } from "../types"

export const config = (): JaLivewireConfig => {
  return __JA_LIVEWIRE_CONFIG__ || {}
}