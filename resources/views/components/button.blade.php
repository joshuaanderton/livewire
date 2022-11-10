<{{ $tag }} {{ $attributes->merge(['type' => 'button', 'href' => $href]) }}>

    @if ($icon)
        <span><x-icon :name="$icon" class="h-5 w-5" /></span>
    @endif

    @if ($text || $slot->isNotEmpty())
        <span class="flex-1">{{ $text }}{{ $slot }}</span>
    @endif

</{{ $tag }}>