@php $model = $attributes->wire('model')->value() @endphp

<div x-data class="{{ $wrapperClass }}">

  @if ($label)
    <x-jal::label x-on:click="$refs.input.select()" :text="$label" />
  @endif

  <div class="{{ $label ? 'mt-2' : '' }} {{ ($attributes['disabled'] ?? false) ? 'bg-gray-200' : 'bg-white' }} flex border border-gray-200 rounded focus-within:ring-1 focus-within:ring-gray-200 focus-within:border-gray-200">
    
    @if ($icon || $prepend)
      <span x-on:click="$refs.input.select()" class="flex m-0 select-none cursor-text {{ $sm ? 'text-sm' : '' }}">
    @endif

    @if ($icon)
      <div class="flex items-center justify-center pl-3 text-gray-300">
        <x-jal::icon :type="null" :class="null" :name="$icon" />
      </div>
    @endif

    @if ($prepend)
      <div class="flex items-center whitespace-nowrap {{ $icon ? 'pl-2' : 'pl-3' }} text-gray-400">
        {!! $prepend !!}
      </div>
    @endif

    @if ($icon || $prepend)
      </span>
    @endif

    <input {{ $attributes->merge([
      'type' => $type,
      'x-ref' => 'input',
      'name' => $name,
      'autocomplete' => $autocomplete ?: null,
      'class' => $class, 
    ]) }} />

    @if ($slot->isNotEmpty())
      {!! $slot !!}
    @endif

  </div>

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