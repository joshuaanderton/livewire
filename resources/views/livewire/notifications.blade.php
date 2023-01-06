<div>
    
    @if ($successMessage)
        <x-jal::notification :text="$successMessage" success />
    @endif

    @if ($errorMessage)
        <x-jal::notification :text="$errorMessage" error />
    @endif

    @if ($infoMessage)
        <x-jal::notification :text="$infoMessage" persist />
    @endif

</div>