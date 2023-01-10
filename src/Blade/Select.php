<?php

namespace Ja\Livewire\Blade;

class Select extends Input
{
    public array $options = [];
    
    public $cssClasses = [
        'block',
        'w-full',
        'rounded-md',
        'border-gray-300',
        'py-2',
        'pl-3',
        'pr-10',
        'text-base',
        'focus:ring-0',
        'focus:outline-none',
        // 'focus:border-black',
        // 'focus:outline-none',
        // 'focus:ring-black',
        // 'sm:text-sm'
    ];
}