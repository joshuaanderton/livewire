<div>
    
    @if ($successMessage)
        <x-tall::notification :text="$successMessage" success />
    @endif

    @if ($errorMessage)
        <x-tall::notification :text="$errorMessage" error />
    @endif

    @if ($infoMessage)
        <x-tall::notification :text="$infoMessage" persist />
    @endif

</div>