<?php

namespace Ja\Livewire\Blade\Traits;

use Ja\Livewire\Support\Blade as JaBlade;
use Illuminate\Support\Arr;
use Exception;

/**
 * @resource https://github.com/vuejs/petite-vue
 */

trait Petiteable
{
    public array $petite;

    public string $script = '<script src="https://unpkg.com/petite-vue" defer init></script>';

    private function getPetite(): string
    {
        return json_encode($this->petite);
    }

    public function renderPetite()
    {
        $petite = <<<'blade'
            <div id="{{ $componentId }}" v-scope="{{ $petite }}">
                {{ $component }}
            </div>
        blade;

        $petite = static::createBladeViewFromString(app('view'), $petite);

        return view($petite, Tall::arr(
            component: $this->render(),
            petite: $this->getPetite();
        ));
    }
}