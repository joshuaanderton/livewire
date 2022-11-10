import tailwindcss from 'tailwindcss'

import {
  envConfig,
  aliasConfig,
  devServerConfig,
  _envIs,
  _set,
  _merge
} from './resources/js/vite'

interface TallConfigProps {
  tailwind: boolean|undefined
}

export const defineConfig = (
  config: object = {},
  tall: TallConfigProps = {tailwind: true}
) => {

  const isDev = _envIs(['local', 'development'], config.mode)

	if (tall.tailwind === true) {
    config = _merge(config, 'plugins', [
      tailwindcss()
    ])
  }

  // Set default env variables
	config = envConfig(config)

  // Add default aliases (e.g. alias @ -> ./resources/js)
	config = aliasConfig(config)

  // Configure dev server (e.g. valet https, HMR, etc.)
	if (isDev) {
		config = devServerConfig(config)
	}

	// Pass to vite
	return config;
}