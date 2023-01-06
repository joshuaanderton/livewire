<?php

namespace Ja\Livewire\Support;

use Exception;
use Illuminate\View\Component as BladeComponent;

class Blade
{
    /**
     * Check to see if component class uses a certain component trait
     *
     * @return boolean
     */
    public static function componentHasTrait(string|BladeComponent $component, string $trait)
    {
        if (! trait_exists($trait)) {
            throw new Exception(
                "\"{$trait}\" component trait does not exists"
            );
        }

        if (is_string($component) && !is_subclass_of($component, BladeComponent::class)) {
            throw new Exception(
                "\"{$component}\" is not a subclass of \"" . BladeComponent::class . "\""
            );
        }

        return in_array(
            $trait,
            class_uses($component)
        );
    }

    /**
     * Check if component has certain property defined
     *
     * @var BladeComponent $component
     * @var string|array $classNames
     * @return void
     */
    public static function hasProperty(BladeComponent $component, string $property): bool
    {
        return in_array($property, array_keys(get_object_vars($component)));
    }
}