<?php

namespace Ja\Tall\Blade;

class Icon extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
