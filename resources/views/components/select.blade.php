@php
  $model = $attributes->wire('model')->value();
  $id = $model ?: $name ?: uniqueId();
  $class = $label ? "{$class} mt-2" : $class;
@endphp

<div class="{{ $wrapperClass }}">

  @if ($label)
    <x-label for="{{ $id }}" :text="$label" />
  @endif

  <select wire:ignore {{ $attributes->merge(compact('type', 'name', 'class', 'id')) }}>
    @if ($slot->isNotEmpty())
      {!! $slot !!}
    @endif
    @foreach ($options as $value => $label)
      <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
  </select>

  @if ($disclaimer)
    @if ($disclaimer->attributes ?? false)
    <div {{ $disclaimer->attributes->merge(['class' => 'mt-1 text-xs text-gray-500']) }}>
    @else
    <div class="mt-1 text-xs text-gray-500">
    @endif
      {!! $disclaimer !!}
    </div>
  @endif

  @error($model ?: $name)
    <x-jal::validation-error :message="$message" />
  @enderror
    
</div>