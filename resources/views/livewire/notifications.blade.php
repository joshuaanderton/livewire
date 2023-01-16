<div aria-live="assertive" class="{{ $messages->count() === 0 ? 'hidden' : 'flex' }} flex-col pointer-events-none fixed inset-0 items-end p-4 sm:items-start sm:p-6 z-[100]">
    
    @foreach ($messages as $message)
        
        <x-jal::notification
            id="{{ $message['id'] }}"
            wire:key="{{ $message['id'] }}"
            :text="$message['text']"
            :success="$message['success'] ?? false"
            :error="$message['error'] ?? false"
            :persist="$message['persist'] ?? false" />

    @endforeach

</div>