<?php

namespace Ja\Livewire\Livewire;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Livewire\Component;

class Notifications extends Component
{
    public Collection $messages;

    public $listeners = [
        'success-message' => 'showSuccessMessage',
        'error-message' => 'showErrorMessage',
        'info-message' => 'showInfoMessage'
    ];

    public function mount()
    {
        $this->messages = new Collection;

        if ($message = session()->get('success-message')) {
            $this->showSuccessMessage($message);
        }

        if ($message = session()->get('error-message')) {
            $this->showErrorMessage($message);
        }

        if ($message = session()->get('info-message')) {
            $this->showInfoMessage($message);
        }
    }

    public function showSuccessMessage(string $message): void
    {
        $this->messages->push([
            'id' => (string) Str::orderedUuid(),
            'text' => $message,
            'success' => true,
        ]);
    }

    public function showErrorMessage(string $message): void
    {
        $this->messages->push([
            'id' => (string) Str::orderedUuid(),
            'text' => $message,
            'error' => true,
        ]);
    }

    public function showInfoMessage(string $message): void
    {
        $this->messages->push([
            'id' => (string) Str::orderedUuid(),
            'text' => $message,
            'persist' => true,
        ]);
    }

    public function render()
    {
        return view('ja-livewire::livewire.notifications');
    }
}
