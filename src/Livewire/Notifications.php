<?php

namespace Ja\Livewire\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public ?string $successMessage = null;

    public ?string $errorMessage = null;

    public ?string $infoMessage = null;

    public $listeners = [
        'success-message' => 'showSuccessMessage',
        'error-message' => 'showErrorMessage',
        'info-message' => 'showInfoMessage'
    ];

    public function mount()
    {
        if ($message = session()->get('success-message')) {
            $this->successMessage = $message;
        }

        if ($message = session()->get('error-message')) {
            $this->errorMessage = $message;
        }

        if ($message = session()->get('info-message')) {
            $this->infoMessage = $message;
        }
    }

    public function showSuccessMessage(string $message): void
    {
        $this->successMessage = $message;
    }

    public function showErrorMessage(string $message): void
    {
        $this->errorMessage = $message;
    }

    public function showInfoMessage(string $message): void
    {
        $this->infoMessage = $message;
    }

    public function render()
    {
        return view('jal::livewire.notifications');
    }
}
