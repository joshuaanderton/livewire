<?php

namespace TallStackApp\Tools\Blade;

use Illuminate\View\Component;

class Transition extends Component
{
    public array $transition = [];

    private $transitionTags = [
        'x-transition:enter',
        'x-transition:enter-start',
        'x-transition:enter-end',
        'x-transition:leave',
        'x-transition:leave-start',
        'x-transition:leave-end',
    ];

    public function __construct(array $transition)
    {
        foreach ($transition as $i => $t) :
            $this->transition[$this->transitionTags[$i]] = $t;
        endforeach;
    }

    public function render()
    {
        return view('tall::components.transition');
    }
}
