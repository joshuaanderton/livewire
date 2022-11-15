import tailwindcss from 'tailwindcss'
import { UserConfig } from 'vite'
import {
  aliasConfig,
  devServerConfig,
  _envIs,
  _set,
  _merge
} from './resources/js/vite'

interface TallConfigProps {
  tailwind: boolean|undefined
}

export default (options: TallConfigProps) => ({

  name: 'tall',
  
  config: (config: UserConfig, { mode, command }: { mode: string, command: string }) => {

    if (!['build', 'serve'].includes(command)) {
      return config
    }

    if (options.tailwind === true) {
      config = _merge(config, 'plugins', [
        tailwindcss()
      ])
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