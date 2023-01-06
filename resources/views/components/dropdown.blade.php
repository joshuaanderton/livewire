<div x-cloak {{ $attributes->merge([
  'x-data' => '{ open: false }',
  'class' => $class,
  'x-on:click' => 'open = true',
  'x-on:click.away' => 'open = false',
  'x-init' => $xShow ? '$watch("open", value => $data.' . $xShow . ' = value) }' : null,
]) }}>

  <div>
    @if ($button->attributes ?? false)
      {{ $button }}
    @else
      <button
        type="button"
        aria-expanded="true"
        aria-haspopup="true"
        class="{{ $buttonCssClasses }}"
      >
        <span>{{ $button }}</span>
        <x-tall::icon name="chevron-down" sm />
      </button>
    @endif
  </div>

  <x-tall::transition
    x-show="open"
    :transition="[
      'transition ease-out duration-200',
      'transform opacity-0 scale-95',
      'transform opacity-100 scale-100',
      'transition ease-in duration-75',
      'transform opacity-100 scale-100',
      'transform opacity-0 scale-95'
    ]"
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="menu-button"
    tabindex="-1"
    class="{{ $menuCssClasses }}"
  >
    <div class="py-1" role="none">
      {{ $slot }}
    </div>
  </x-tall::transition>

</div>