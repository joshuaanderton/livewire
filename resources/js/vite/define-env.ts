import { _env, _json, _merge } from './utils'

export default (config: object = {}) => {
	
	const host = config.host || null,
        mode = config.mode,
        appEnv = _env('APP_ENV', '', config.mode)

	config = _merge(config, 'define', {
		__APP_NAME__: _json(_env('APP_NAME', null, mode)),
		__APP_URL__:  _json(_env('APP_URL', host, mode)),
		__APP_ENV__:  _json(appEnv),
	})

  return config;
}