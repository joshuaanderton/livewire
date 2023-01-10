<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-neutral-800 dark:text-neutral-100']) }}>
  {{ $text }}{{ $slot }}
</label>