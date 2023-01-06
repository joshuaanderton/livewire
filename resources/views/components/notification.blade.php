<div
    x-data="{
        open: true,
        persist: {{ $persist ? 'true' : 'false' }},
        init() {
            if (this.persist) {
                return
            }

            setTimeout(() => open = false, 2500)
        }
    }"
    aria-live="assertive"
    class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-[100]"
>
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">

        <x-jal::transition
            x-show="open"
            :transition="[
                'transform ease-out duration-300 transition',
                'translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2',
                'translate-y-0 opacity-100 sm:translate-x-0',
                'transition ease-in duration-100',
                'opacity-100',
                'opacity-0'
            ]"
            class="pointer-events-auto w-full overflow-hidden ring-1 ring-black ring-opacity-5 dark:shadow-glass dark:backdrop-blur-sm max-w-sm mb-3 rounded-lg shadow-lg cursor-pointer"
        >

            @if ($error)
                <div @click="open = false" class="group bg-red-50 dark:bg-red-400/[.70] p-4 flex items-start">
                    <div class="shrink-0">
                        <svg class="w-6 h-6 text-red-400 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1 w-0 ml-3 text-left">
                        <p class="text-sm leading-5 font-medium text-red-800 dark:text-white">{{ $heading }}</p>
                        <p class="mt-1 text-sm leading-5 text-red-700 dark:text-red-200">{{ $text }}{{ $slot }}</p>
                    </div>
                    <div class="flex shrink-0">
                        <button class="text-red-400 focus:text-red-500 dark:text-red-100 inline-flex w-5 h-5 transition duration-150 ease-in-out focus:outline-none">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <div @click="open = false" class="group bg-white p-4 flex items-start">
                    <div class="flex-shrink-0">
                        @if ($success)
                            <x-jal::icon name="check-circle" class="text-green-400" />
                        @else
                            <x-jal::icon name="info-circle" class="text-sky-400" />
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $heading }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ $text }}{{ $slot }}</p>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button type="button" class="inline-flex rounded-md bg-white text-gray-400 group-hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <!-- Heroicon name: mini/x-mark -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

        </x-jal::transition>

    </div>
</div>
