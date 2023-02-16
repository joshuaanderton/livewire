<?php

namespace LivewireKit\Support\Blade;

use Illuminate\View\Component;

class CreateBladeView extends Component
{
    public static function fromString(string $content): string
    {
        return (new static())->createBladeViewFromString(
            app('view'),
            $content
        );
    }

    public function render() {}
}
