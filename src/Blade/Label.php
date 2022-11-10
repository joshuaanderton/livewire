<?php

namespace Ja\Tall\Blade;

use Ja\Tall\Blade\Traits\Translatable;
use Ja\Tall\Blade as Component;

class Label extends Component
{
    use Translatable;

    protected array $translatable = ['text'];

    public ?string $text;

    public bool $required = false;

    public string $tag = 'label';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $text = null, bool $required = null, string $as = null)
    {
        $this->text = $text;
        $this->required = ! ! $required;
        
        if ($as) {
            $this->tag = $as;
        }
    }
}
