@if ($confirm)
<div
    class="relative z-1"
    x-data="{
        confirming: false,
        confirm(event) {
            if (!this.confirming) {
                this.confirming = true

                event.preventDefault()
                return false
            }
            
            this.confirming = false
        },
        init() {
            $refs.button.addEventListener('click', event => this.confirm(event))
        }
    }"
>
@endif

<{{ $tag }} {{ $attributes->merge(['x-ref' => 'button', 'type' => $tag === 'button' ? ($attributes['type'] ?: 'button') : null, 'href' => $href]) }}>

    @if ($icon)
        <span>
            <x-tall::icon :type="null" :name="$icon" />
        </span>
    @endif

    @if ($text || $slot->isNotEmpty())
        @if ($confirm)
            <span class="flex-1 text-left" x-show="confirming">
                {{ $confirmText }}
            </span>
        @endif
        <span class="flex-1 text-left" {!! $confirm ? 'x-show="!confirming"' : '' !!}>
            {{ $text }}{{ $slot }}
        </span>
    @endif

    <span wire:loading {!! $attributes['wire:click'] ? "wire:target='{$attributes['wire:click']}'" : '' !!}>
        <x-tall::icon-loading class="h-5 w-5" />
    </span>

</{{ $tag }}>

@if ($confirm)
</div>
@endif