@if ($label || $slot->isNotEmpty())
    <label class="relative flex items-start">
@endif

<div class="flex items-center h-5">
    <input {{ $attributes->merge(['type' => 'checkbox']) }} />
</div>

@if ($label || $slot->isNotEmpty())
        <div class="ml-3 text-sm">
            <div class="font-medium text-gray-800 dark:text-white cursor-pointer">
                {{ $label }}{{ $slot }}
            </div>
        </div>
    </label>
@endif

@error($model)
    <x-jal::validation-error :model="$model" />
@enderror