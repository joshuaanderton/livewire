<label
    @class(array_merge(explode(' ', $wrapperClass), [
        'relative',
        'flex',
        'items-start',
        'cursor-pointer'
    ]))
    x-data="{
        toggled: undefined,
        model: undefined,
        init() {
            this.model = $refs.input.getAttribute('wire:model')
            this.toggled = $wire.get(this.model)

            $watch('toggled', value => $wire.set(this.model, value))
        }
    }"
>

    <div class="flex items-center h-5 {{ $right ? 'order-1 ml-3' : 'mr-3' }}">
        
        <input type="checkbox" style="display:none" {{ $attributes->merge(['x-ref' => 'input', 'x-model' => 'toggled']) }} />
        
        <span
            :class="toggled ? 'bg-primary-600' : 'bg-gray-200'"
            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
            role="switch"
            aria-checked="false"
        >
            <span
                aria-hidden="true"
                :class="toggled ? 'translate-x-5' : 'translate-x-0'"
                class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
        </span>
    </div>

    @if ($label || $slot->isNotEmpty())
        <div class="text-sm {{ $right ? 'order-0' : '' }}">
            <div class="font-medium text-gray-800 dark:text-white cursor-pointer">
                {{ $label }}{{ $slot }}
            </div>
        </div>
    @endif

</label>

@error($model)
    <x-jal::validation-error :model="$model" />
@enderror  