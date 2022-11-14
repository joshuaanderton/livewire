## Tools for making wicked-awesome TALL stack apps

```
composer require tallstackapp/tools
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
