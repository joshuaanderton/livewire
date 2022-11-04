<?php

namespace Ja\Tall;

use Ja\Tall\Contracts\Traits\WithActionValidate;
use Ja\Tall\Contracts\Traits\WithLivewireRulePrefix;

abstract class Contract
{
    use WithActionValidate,
        WithLivewireRulePrefix;
}