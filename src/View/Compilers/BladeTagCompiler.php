<?php declare (strict_types=1);

namespace Ja\Livewire\View\Compilers;

use Ja\Livewire\View\Compiler;

class BladeTagCompiler extends Compiler
{
    protected function tag(): string
    {
        return 'blade[-\:]([\w\-\:\.]*)';
    }
    
    protected function componentFromTag(string $tag): string|array
    {
        return $tag;
    }
}
