@php $model = $attributes->wire('model')->value() @endphp

<div x-data class="{{ $wrapperClass }}">

  @if ($label)
    <x-label x-on:click="$refs.input.select()" :text="$label" />
  @endif

  <div class="{{ $label ? 'mt-2' : '' }} flex border border-gray-200 rounded {{ ($attributes['disabled'] ?? false) ? 'bg-gray-200' : 'bg-white' }} focus-within:ring-1 focus-within:ring-gray-200 focus-within:border-gray-200 {{ $sm ? 'h-8' : 'h-10' }}">
    
    @if ($icon || $prepend)
      <label x-on:click="$refs.input.select()" class="flex m-0 select-none cursor-text {{ $sm ? 'text-sm' : '' }}">
    @endif

    @if ($icon)
      <div class="flex items-center justify-center pl-3 text-gray-300">
        <x-tall::icon :name="$icon" />
      </div>
    @endif

    @if ($prepend)
      <div class="flex items-center whitespace-nowrap {{ $icon ? 'pl-2' : 'pl-3' }} text-gray-400">
        {!! $prepend !!}
      </div>
    @endif

    @if ($icon || $prepend)
      </label>
    @endif

    <input 
      wire:ignore
      {{ $attributes->merge([
        'type' => $type,
        'x-ref' => 'input',
        'autocomplete' => $autocomplete ?: null,
        'class' => $class, 
      ]) }}
    />

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

  @error($model)
    <x-tall::validation-error :message="$message" />
  @enderror
    
</div>