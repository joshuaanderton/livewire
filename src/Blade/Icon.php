<?php

namespace TallStackApp\Tools\Blade;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use TallStackApp\Tools\Support\Helper as Tall;
use TallStackApp\Tools\Blade as Component;

class Icon extends Component
{
    public string $name;

    public ?string $svg = null;

    public string $library;

    public string $type;

    private array $types = [
        'heroicons' => [
            'solid',
            'outline',
            'mini',
        ],
        'fontawesome' => [
            'solid',
            'regular',
            'light',
            'thin',
            'duotone',
            'brands',
        ]
    ];

    protected bool $xs;

    protected bool $sm;

    protected bool $md;

    protected bool $lg;

    public function __construct(
        string $name,
        string $library = null,
        string $type = null,
        bool $xs = null,
        bool $sm = null,
        bool $md = null,
        bool $lg = null
    ) {
        $this->name = $name;
        $this->library = $library ?: 'heroicons';
        $this->type = $type ?: 'solid';
        $this->xs = !! $xs;
        $this->sm = !! $sm;
        $this->md = !! $md;
        $this->lg = !! $lg;

        // Support for name="fa-brands fa-rocket" (etc.)
        if (!$library && (Str::startsWith($name, 'fa-') || Str::contains($name, ' fa-'))) {
            
            $this->library = 'fontawesome';

            $keys = (
                collect(explode('fa-', $name))
                    ->map(fn ($key) => trim($key) ?: null)
                    ->whereNotNull()
            );

            $this->name = $keys->filter(fn ($key) => !in_array($key, $this->types()))->first();

            if (!$type) {
                $this->type = $keys->filter(fn ($key) => in_array($key, $this->types()))->first() ?: $this->type;
            }
        }

        if (!$this->types()) {
            throw new Exception(
                "[{$this->library} is not a supported icon library (options are " . join(', ', array_keys($this->types)) . ")"
            );
        }
        
        if (!in_array($this->type, $this->types())) {
            throw new Exception(
                "[{$this->type}] is not a supported {$this->library} icon type (options are " . join(', ', $this->types()) . ")"
            );
        }

        if ($this->library === 'fontawesome') {
            return;
        }

        if (
            $this->library === 'heroicons' &&
            !($svg = $this->getSvg($this->name))
        ) {
            throw new Exception(
                "[{$this->name}] is not a supported icon (full list at https://heroicons.com)"
            );
        }
        
        $this->svg = $svg;
    }

    private function types(): array|null
    {
        return $this->types[$this->library] ?? null;
    }

    private function getSvg()
    {
        $path = Tall::packageViewsPath(
            'components/icons/heroicons',
            $this->type,
            "{$this->name}.svg"
        );

        if (File::exists($path)) {
            return File::get($path);
        }

        return null;
    }

    public function render()
    {
        return match ($this->library) {
            'fontawesome' => <<<'blade'
                <i {{ $attributes->merge(['class' => "fa-{$type} fa-{$name} " . ($attributes['class'] ?: '')]) }}></i>
            blade,

            'heroicons' => <<<'blade'
                <span {{ $attributes->merge(['class' => 'fill-current']) }}>{!! $svg !!}</span>
            blade,
        };
    }
}
