import { UserConfig, searchForWorkspaceRoot } from 'vite'
import { process, path } from 'node'
import { _merge } from './resources/js/vite'

export default () => ({

  name: 'ja-livewire',
  
  config: (config: UserConfig, { mode, command }: { mode: string, command: string }) => {

    if (!['build', 'serve'].includes(command)) {
      return config
    }
  
    // Add default aliases (e.g. alias @ -> ./resources/js)
    const packagePath = __dirname

    // Support symlinks for aliasing vendor packages
    if (config.preserveSymlinks !== false) {
      config.preserveSymlinks = true
    }

    // Allow aliasing this package
    config = _merge(config, 'server.fs.allow', [
      path.resolve(packagePath),
      searchForWorkspaceRoot(process.cwd())
    ])

    config = _merge(config, 'resolve.alias', {
      '@ja-livewire': path.resolve(`${packagePath}/resources/js`),
      '~': path.resolve('./node_modules'),
      '@': path.resolve('./resources/js'),
    })

    if (mode !== 'development') {
      return config
    }
  
    // Configure dev server (e.g. valet https, HMR, etc.)
    // config = devServerConfig(config, mode)
    
    return config
  }
})