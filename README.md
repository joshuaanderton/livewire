## Tools for making wicked-awesome TALL stack apps

```
composer require tallstackapp/tools
```

Import component JS and CSS dependencies:
```
// ./vite.config.ts
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tall from './vendor/tallstackapp/tools'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/js/legacy.js',
                'resources/scss/legacy.scss',
            ],
            refresh: true,
        }),
        tall()
    ]
})
```

Include package views in tailwind config:
```
// ./tailwind.config.js

module.exports = {
  darkMode: 'class',
	content: [
		'./resources/views/**/*.blade.php',
    './vendor/tallstackapp/tools/**/*.blade.php',
	],
  ...
```

### Blade Components
Tons of reuseable & extendible components (via TailwindCSS + AlpineJS).

#### Icons (via [tailwindlabs/heroicons](https://github.com/tailwindlabs/heroicons))
```
<x-tall::icon name="bug-ant" outline />
```

#### Buttons
```
<x-tall::button
  :route="['products.show', $product]"  // Route uri is retrieved (if exists) and rendered as href="" attribute
  text="products.view_product"          // Text attribute translated (if translation exists)
  icon="cart"                           // Icon component utilized within
  icon-type="solid"
  lg />

// Slot supported too of course!
<x-tall::button href="products">View Products</x-tall::button>
```
