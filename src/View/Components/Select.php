<?php declare (strict_types=1);

namespace Ja\Livewire\View\Components;

class Select extends Input
{
    public array $options = [];

    public $cssClasses = [
        'block',
        'w-full',
        'rounded-md',
        'border-transparent',
        'bg-neutral-50',
        'dark:bg-neutral-800',
        'py-1',
        'pl-3',
        'pr-10',
        'text-base',
        'focus:ring-0',
        'focus:outline-none',
        'focus:ring-1',
        'focus:ring-neutral-200',
        'focus:border-neutral-200',
    ];
}
