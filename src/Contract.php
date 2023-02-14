<?php

namespace Ja\Livewire;

use Ja\Livewire\Contracts\Traits\WithActionValidate;
use Ja\Livewire\Contracts\Traits\WithLivewireRulePrefix;

abstract class Contract
{
    use WithActionValidate;
    use WithLivewireRulePrefix;
}
