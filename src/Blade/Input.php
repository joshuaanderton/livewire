<?php

namespace Ja\Livewire\Blade;

use Illuminate\Support\Str;
use Ja\Livewire\Blade\Traits\Mergeable;
use Ja\Livewire\Blade\Traits\CssClassable;
use Ja\Livewire\Blade\Traits\Routable;
use Ja\Livewire\Blade\Traits\Translatable;
use Ja\Livewire\Blade as Component;

class Input extends Component
{
    use CssClassable,
        Routable,
        Mergeable,
        Translatable;

    public string $type;

    public ?string $name;

    public ?string $label;

    public ?string $disclaimer;

    public ?string $icon;

    public ?string $prepend;

    public string|array|null $class;

    public ?string $wrapperClass;

    public $spaceAbove;

    public $autocomplete;

    public $sm;

    public $cssClasses = [
        'block',
        'w-full',
        'placeholder-gray-400',
        'border-0',
        'focus:ring-0',
        'bg-transparent',
        'h-full',
    ];

    public function __construct(
    string $type = null,
    string $name = null,
    string $label = null,
    string $disclaimer = null,
    string $icon = null,
    string $prepend = null,
    string $class = '',
    string $wrapperClass = null,
    bool $spaceAbove = null,
    string $autocomplete = null,
    bool $small = null, // deprecating
    bool $sm = null
  ) {
        $this->type = $type ?: 'text';
        $this->name = $name;
        $this->label = $label;
        $this->disclaimer = $disclaimer;
        $this->icon = $icon;
        $this->prepend = $prepend;
        $this->spaceAbove = $spaceAbove;
        $this->sm = $small ?: (!! $sm);

        $this->class = $this->classes($class);
        $this->wrapperClass = $wrapperClass;

        if ($autocomplete) {
            $this->autocomplete = $autocomplete;
        } else {
            $this->smartAutocomplete();
        }

        if ($this->spaceAbove) {
            $this->wrapperClass = "mt-6 {$this->wrapperClass}";
        }
    }

    public function classes(string $class = '')
    {
        if ($this->sm) {
            $this->cssClasses[] = 'text-sm';
        }

        if ($this->prepend) {
            $this->cssClasses[] = 'pl-0';
        }

        return implode(' ', array_merge($this->cssClasses, explode(' ', $class)));
    }

    private function smartAutocomplete()
    {
        if ($this->type == 'email') {
            $this->autocomplete = 'username';
        } elseif ($this->type == 'password') {
            $this->autocomplete = 'new-password';
        }

        // foreach ([
        //     'first_name' => 'given-name',
        //     'last_name' => 'family-name',
        //     'phone_number' => 'tel',
        //     'url' => 'url',
        // ] as $field => $value) {
        //     if (
        //         $this->model !== $field &&
        //         !Str::contains($this->model, ".{$field}")
        //     ) {
        //         continue;
        //     }

        //     $this->autocomplete = $value;
        // }
    }

    public function render()
    {
        return view('jal::components.input');
    }
}