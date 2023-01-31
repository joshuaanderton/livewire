<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-neutral-800 dark:text-neutral-100']) }}>
  {{ $text }}{{ $slot }} @if ($required)<span class="text-sm text-red-500">*</span>@endif
</label>