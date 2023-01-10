@php
  $model = $attributes->wire('model')->value();
  $id = $model ?: $name ?: (string) Str::orderedUuid();
  if ($label) {
    $attributes['class'] = "{$attributes['class']} mt-2";
  }
@endphp

<div class="{{ $wrapperClass }}">

  @if ($label)
    <x-jal::label for="{{ $id }}" :text="$label" />
  @endif

  <select {{ $attributes->merge(compact('type', 'name', 'id')) }}>
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