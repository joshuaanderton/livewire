<div
    x-data="{
        open: true,
        persist: {{ $persist ? 'true' : 'false' }},
        close() {
            $data.open = false
            setTimeout(() => $el.remove(), 600)
        },
        init() {
            $nextTick(() => {
                if ($data.persist) {
                    return
                }

                setTimeout($data.close, 2500)
            })
        }
    }"
    x-on:click="close" 
    class="flex w-full flex-col items-center sm:items-end"
>

    <x-jal::transition
        x-show="open"
        :transition="[
            'transform ease-out duration-500 transition',
            'translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2',
            'translate-y-0 opacity-100 sm:translate-x-0',
            'transition ease-in duration-100',
            'opacity-100',
            'opacity-0'
        ]"
        class="pointer-events-auto w-full pb-4"
    >
        <div class="group {{ $error ? 'bg-red-50 dark:bg-red-400/[.70]' : 'bg-white dark:bg-neutral-700' }} p-4 flex items-start overflow-hidden ring-1 ring-black ring-opacity-5 dark:shadow-glass dark:backdrop-blur-sm max-w-sm w-full ml-auto rounded-lg shadow-lg cursor-pointer">
            <div class="flex-shrink-0">
                @if ($success)
                    <x-jal::icon name="check-circle" class="text-green-400" />
                @elseif ($error)
                    <x-jal::icon name="exclamation-circle" class="text-red-400" />
                @else
                    <x-jal::icon name="info-circle" class="text-sky-400" />
                @endif
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-black/90 dark:text-white/90">{{ $heading }}</p>
                <p class="mt-1 text-sm text-black/70 dark:text-white/70">{{ $text }}{{ $slot }}</p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button type="button" class="inline-flex rounded-md text-black/50 dark:text-white/50 group-hover:text-black/70 dark:group-hover:text-white/70 transition-colors">
                    <x-jal::icon name="x-mark" class="h-5 w-5" />
                </button>
            </div>
        </div>

    </x-jal::transition>

</div>
