@php $model = $attributes->wire('model')->value() @endphp

<div class="{{ $wrapperClass }}">

  @if ($label)
    <x-jal::label :for="$id" :text="$label" />
  @endif

  <div class="{{ $label ? 'mt-2' : '' }} {{ ($attributes['disabled'] ?? false) ? 'bg-neutral-200' : 'bg-neutral-50 dark:bg-neutral-800' }} flex border border-transparent rounded overflow-hidden focus-within:ring-1 focus-within:ring-neutral-200 focus-within:border-neutral-200">
    
    @if ($icon || $prepend)
      <span onclick="document.getElementById('{{ $id }}').select()" class="relative flex m-0 select-none cursor-text {{ $sm ? 'text-sm' : '' }}">
    @endif

    @if ($icon)
      <div class="flex items-center justify-center pl-3 text-neutral-300">
        <x-jal::icon :type="null" :class="null" :name="$icon" />
      </div>
    @endif

    @if ($prepend && $prepend->attributes ?? false)
      <div {{ $prepend->attributes->merge(['flex items-center whitespace-nowrap text-neutral-400' . ($icon ? ' pl-2' : '') ]) }}>
        {!! $prepend !!}
      </div>
    @elseif ($prepend)
      <div class="flex items-center whitespace-nowrap {{ $icon ? 'pl-2' : 'pl-3' }} text-neutral-400">
        {!! $prepend !!}
      </div>
    @endif

    @if ($icon || $prepend)
      </span>
    @endif

    <input {{ $attributes->merge([
      'id' => $id,
      'type' => $type,
      'name' => $name,
      'autocomplete' => $autocomplete ?: null,
    ]) }} />

    @if ($slot->isNotEmpty())
      {!! $slot !!}
    @endif

  </div>

  @if ($disclaimer)
    @if ($disclaimer->attributes ?? false)
    <div {{ $disclaimer->attributes->merge(['class' => 'mt-1 text-xs text-neutral-500']) }}>
    @else
    <div class="mt-1 text-xs text-neutral-500">
    @endif
      {!! $disclaimer !!}
    </div>
  @endif

  @error($model ?: $name)
    <x-jal::validation-error :message="$message" />
  @enderror
    
</div>