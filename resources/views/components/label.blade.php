<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-700']) }}>
  {{ $text }}{{ $slot }}
</label>