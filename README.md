## Tools for making great SaaS apps with Livewire + Laravel

```
composer require joshuaanderton/livewire
```

Import component JS and CSS dependencies:
```
// ./vite.config.ts
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import jaLivewire from './vendor/joshuaanderton/livewire'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    jaLivewire()
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
    './vendor/joshuaanderton/livewire/**/*.blade.php',
	],
  ...
```

### Blade Components
Tons of reuseable & extendible components (via TailwindCSS + AlpineJS).

#### Icons (via [tailwindlabs/heroicons](https://github.com/tailwindlabs/heroicons))
```
<x-jal::icon name="bug-ant" outline />
```

#### Buttons
```
<x-jal::button
  :route="['products.show', $product]"  // Route uri is retrieved (if exists) and rendered as href="" attribute
  text="products.view_product"          // Text attribute translated (if translation exists)
  icon="cart"                           // Icon component utilized within
  icon-type="solid"
  lg />

// Slot supported too of course!
<x-jal::button href="products">View Products</x-jal::button>
```
