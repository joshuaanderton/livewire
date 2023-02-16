<div wire:ignore x-data="jalFileInput">

    @if ($label)
        <x-label :text="$label" />
    @endif

    <div @class([
        $wrapperClass,
        'mt-1' => $label,
        'min-h-[100px]',
        'relative',
        'flex',
        'items-center',
        'justify-center',
        'p-2',
        'border-2',
        'border-dashed',
        'rounded-md',
        'avatar-upload',
        'border-neutral-200',
        'transition-all',
        'duration-300',
        'ease-in-out',
        'isolate',
        'hover:border-neutral-300',
        'group',
        'bg-neutral-50',
        'dark:bg-neutral-800',
        'dark:border-neutral-600',
        'cursor-pointer',
    ])>
        <input {{ $attributes->merge([
            'x-ref'       => 'input',
            'type'        => 'file',
            'accept'      => 'image/*',
            'x-on:change' => '$data.updateFiles',
            'class'       => 'hidden'
        ]) }} />

        <button type="button" x-on:click="open" class="cursor-pointer absolute z-10 inset-0 opacity-0"></button>

        <div x-show="multiple || !hasFiles">
            @if ($emptyState)
                {{ $emptyState }}
            @else
                <div class="pointer-events-none flex flex-col items-center space-y-3 py-3">
                    <x-icon name="upload" class="h-5 w-5 text-xl leading-6 text-neutral-400" />

                    <div class="text-sm leading-4 text-center text-neutral-400">
                        Drag a file here or <span class="text-primary-500 hover:text-primary-600 relative z-20"> browse </span> to choose a file 
                    </div>
                </div>
            @endif
        </div>

        <div x-show="multiple && hasFiles" class="pointer-events-none py-3 text-sm leading-4 text-center text-neutral-500 mt-2">
            <ul class="space-y-2">
                <template x-for="(file, index) in files">
                    <li x-key="index" class="uppercase font-medium">
                        <span x-text="file.name" class="mr-1"></span>
                        <span x-text="file.size" class="text-neutral-400"></span>
                    </li>
                </template>
            </ul>
        </div>
        
        <div x-show="!multiple && hasFiles" class="relative">
            <img x-ref="image" :src="preview" class="block rounded h-full w-auto max-w-full">
            <x-button.circle x-on:click="clear" icon="times" class="absolute -bottom-3 -right-3 z-30" />
        </div>

    </div>

    <x-input.error :model="$model" />

</div>