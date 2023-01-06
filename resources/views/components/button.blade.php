<{{ $tag }} {{ $attributes->merge(['type' => $type, 'href' => $href]) }} {!! $confirm ? 'x-data x-button-confirm' : '' !!}>

    @if ($icon)
        <x-jal::icon :type="null" :class="null" :name="$icon" />
    @endif

    @if ($text || $slot->isNotEmpty())
        @if ($confirm)
            <span class="flex-1 {{ !Str::contains($attributes['class'], 'text-center') ? 'text-left' : '' }}" x-show="confirming">
                {{ $confirmText }}
            </span>
        @endif
        <span class="flex-1 {{ !Str::contains($attributes['class'], 'text-center') ? 'text-left' : '' }}" {!! $confirm ? 'x-show="!confirming"' : '' !!}>
            {{ $text }}{{ $slot }}
        </span>
    @endif

    @if ($attributes['wire:click'])
        <x-jal::icon-loading
            wire:loading
            :wire:target="$attributes['wire:click']"
            class="h-5 w-5" />
    @endif

</{{ $tag }}>