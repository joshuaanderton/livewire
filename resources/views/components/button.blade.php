@php
    $confirm = false;
    if ($confirm) {
        $attributes['x-data'] = "{
            confirming: false,
            init() {
                \$el.addEventListener('click', event => {
                    if (\$data.confirming === false) {
                        \$data.confirming = true

                        event.preventDefault()
                        return false
                    }

                    \$data.confirming = false;
                })
            } 
        }";
    }
@endphp

<{{ $tag }} {{ $attributes->merge(['type' => $type, 'href' => $href]) }}>

    @if ($icon)
        <x-jal::icon :type="null" :class="null" :name="$icon" />
    @endif

    @if ($text || $slot->isNotEmpty())
        <span class="flex-1 {{ !Str::contains($attributes['class'], 'text-center') ? 'text-left' : '' }}">
            @if ($confirm)
                <span x-show="confirming">
                    {{ $confirmText }}
                </span>
                <span {!! $confirm ? 'x-show="confirming !== true"' : '' !!}>
                    {{ $text }}{{ $slot }}
                </span>
            @else
                {{ $text }}{{ $slot }}
            @endif
        </span>
    @endif

    @if ($attributes['wire:click'])
        <x-jal::icon-loading
            wire:loading
            :wire:target="$attributes['wire:click']"
            class="h-5 w-5" />
    @endif

</{{ $tag }}>