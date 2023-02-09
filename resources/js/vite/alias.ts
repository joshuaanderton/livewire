import { searchForWorkspaceRoot } from 'vite'
import { _env, _set, _merge } from './utils'
import path from 'path'

export default (config: {preserveSymlinks?: boolean} = {}, packagePath: string) => {
	
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

  return config;
}