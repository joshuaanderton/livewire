import { searchForWorkspaceRoot } from 'vite'
import { _env, _set, _merge } from './utils'
import path from 'path'

export default (config: object = {}) => {
	
	const packagePath = _env('DEV_VENDOR_PATH', './vendor', config.mode)

  // Support symlinks for aliasing vendor packages
	if (config.preserveSymlinks !== false) {
		config.preserveSymlinks = true
	}

  // Allow aliasing this package
  config = _merge(config, 'server.fs.allow', [
    path.resolve(`${packagePath}/joshuaanderton`),
    searchForWorkspaceRoot(process.cwd())
  ])

  config = _merge(config, 'resolve.alias', {
    '@vendor': path.resolve('./vendor'),
    '@tall':   path.resolve(`${packagePath}/joshuaanderton/tall/resources/js`),
    '@':       path.resolve('./resources/js'),
  })

  return config;
}