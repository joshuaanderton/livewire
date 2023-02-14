<?php declare (strict_types=1);

namespace Ja\Livewire\Blade;

use Exception;
use Ja\Livewire\Blade as Component;

class Transition extends Component
{
    public array $transition;

    private array $transitionAttrs = [
        'x-transition:enter',
        'x-transition:enter-start',
        'x-transition:enter-end',
        'x-transition:leave',
        'x-transition:leave-start',
        'x-transition:leave-end',
    ];

    public function __construct(array $transition)
    {
        if (count($transition) !== ($countAttrs = count($this->transitionAttrs))) {
            throw new Exception(
                "Please provide transition classes for all {$countAttrs} x-transition: attributes (e.g. https://alpinejs.dev/directives/transition#applying-css-classes)"
            );
        }

        $this->transition = (
            collect($this->transitionAttrs)
                ->map(fn ($tag, $i) => [$tag => $transition[$i]])
                ->collapse()
                ->all()
        );
    }
}
