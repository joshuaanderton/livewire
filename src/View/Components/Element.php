<?php declare (strict_types=1);

namespace Ja\Livewire\View\Components;

use Ja\Livewire\Support\Blade;
use Ja\Livewire\View\Traits\AlpineJsable;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Element extends Component
{
    use AlpineJsable;

    public string $tagname;

    private bool $selfClosing;

    public bool $if;

    public ?string $class;

    /**
     * @param array<string|int, mixed> $xData
     */
    public function __construct(
        string $tagname,
        ?bool $if = true,
        array|string|null $class = null,
        string|null $xData = null,
        string|null $data = null
    ) {
        $this->tagname = $tagname; //Str::snake(class_basename(get_called_class()));
        $this->selfClosing = Blade::isHtml5SelfClosingTag($tagname);
        $this->if = $if;

        $this->class = is_array($class)
            ? Arr::toCssClasses($class)
            : $class;

        $this->xData = $data ?: $xData;
    }

    public function render()
    {
        if (! $this->if) {
            return '';
        }

        if ($this->selfClosing) {
            return <<<'blade'
                <{{ $tagname }} {!! $xData !== null ? 'x-cloak' : '' !!} {{ $attributes->merge(['class' => $class, 'x-data' => $xData]) }} />
            blade;
        }

        return <<<'blade'
            <{{ $tagname }} {!! $xData !== null ? 'x-cloak' : '' !!} {{ $attributes->merge(['class' => $class, 'x-data' => $xData]) }}>{{ $slot }}</{{ $tagname }}>
        blade;
    }
}
