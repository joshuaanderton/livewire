<?php

namespace Ja\Tall\Blade;

use Exception;
use Ja\Tall\Support\Helper as Tall;
use Ja\Tall\Blade as Component;

class Icon extends Component
{
    public string $svg;
    public string $type;

    private array $types = ['solid', 'outline', 'mini']; 

    public function __construct(string $name, string $type = 'solid')
    {
        $this->name = $name;
        
        if (!in_array($type, $this->types)) {
            throw new Exception(
                "[{$type}] is not a supported icon type (e.g. solid, outline, mini)"
            );
        }

        if (!$svg = $this->getSvg($name)) {
            throw new Exception(
                "[{$name}] is not a supported icon (full list at https://heroicons.com)"
            );
        }

        $this->svg = $svg;
    }

    private function getSvg()
    {
        $path = Tall::viewsPath(
            'components/icon/heroicons',
            $this->type,
            $this->name,
            '.svg'
        );

        if (File::exists($path)) {
            return File::get($path);
        }

        return null;
    }

    public function render()
    {
        return <<<'blade'
            <span {{ $attributes }}>{!! svg !!}</span>
        blade;
    }
}
