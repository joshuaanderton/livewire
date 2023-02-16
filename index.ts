import { UserConfig, searchForWorkspaceRoot } from 'vite'
import path from 'path'
import { _merge, _set } from './resources/js/vite'
import { LivewireKitConfig } from './resources/js/types'

export default (config: LivewireKitConfig = {}) => {
  
  const jaLivewireConfig = config

  return {

    name: 'ja-livewire',
    
    config: (config: UserConfig) => {
    
      const packagePath = __dirname

      config = _merge(config, 'server.fs.allow', [
        path.resolve(packagePath),
        searchForWorkspaceRoot(process.cwd())
      ])

      config = _merge(config, 'resolve.alias', {
        '@ja-livewire': path.resolve(`${packagePath}/resources/js`),
        '~': path.resolve('./node_modules'),
        '@': path.resolve('./resources/js'),
      })

      config = _set(config, 'resolve.preserveSymlinks', true)

      config.define = {
        ...(config.define || {}),
        __JA_LIVEWIRE_CONFIG__: jaLivewireConfig
      }
      
      return config
      
    }
  }
}