<label
    x-data
    x-click="$refs.input.select()"
    class="{{ ! Tailwind::containsType(($class = $attributes['class'] ?? ''), 'display') ? "block {$class}" : $class }}"
  >

    @if ($label)
        <x-jal::label as="span" :for="$id" :text="$label" />
    @endif

    <div class="@class([
        'mt-2' => $label,
        'bg-neutral-200' => $disabled,
        'bg-neutral-50 dark:bg-neutral-800' => ! $disabled,
        'flex',
        'border',
        'border-transparent',
        'rounded',
        'overflow-hidden',
        'focus-within:ring-1',
        'focus-within:ring-neutral-200',
        'focus-within:border-neutral-200'
    ])">
        
        @if ($icon || $prepend)
            <span class="@class([
                'relative',
                'flex',
                'm-0',
                'select-none',
                'cursor-text',
                'text-sm' => $sm,
                'space-x-2' => $icon
            ])">

                @if ($icon)
                    <div class="flex items-center justify-center pl-3 text-neutral-300">
                        <x-jal::icon :name="$icon" :type="$iconType" :class="null" />
                    </div>
                @endif

                @if ($prepend)
                    <div {{ ($prepend->attributes ?? new \Illuminate\View\ComponentAttributeBag)->merge(['class' => 'flex items-center whitespace-nowrap text-neutral-400']) }}>
                        {!! $prepend !!}
                    </div>
                @endif

            </span>
        @endif

        @if ($slot->isNotEmpty())
            {!! $slot !!}
        @endif

    </div>

    @if ($disclaimer)
        @if ($disclaimer->attributes ?? false)
            <div {{ $disclaimer->attributes->merge(['class' => 'mt-1 text-xs text-neutral-500']) }}>{!! $disclaimer !!}</div>
        @else
            <div class="mt-1 text-xs text-neutral-500">{!! $disclaimer !!}</div>
        @endif
    @endif

    @error($model ?: $name)
        <x-jal::validation-error :message="$message" />
    @enderror
        
</label>