import { UserConfig } from 'vite'
import {
  aliasConfig,
  devServerConfig,
  _envIs,
  _set,
  _merge
} from './resources/js/vite'

export default () => ({

  name: 'ja-livewire',
  
  config: (config: UserConfig, { mode, command }: { mode: string, command: string }) => {

    if (!['build', 'serve'].includes(command)) {
      return config
    }
  
    // Add default aliases (e.g. alias @ -> ./resources/js)
    config = aliasConfig(config, __dirname)

    if (mode !== 'development') {
      return config
    }
  
    // Configure dev server (e.g. valet https, HMR, etc.)
    // config = devServerConfig(config, mode)
    
    return config
  }
})