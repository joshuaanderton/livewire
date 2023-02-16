<?php

namespace LivewireKit;

use LivewireKit\Contracts\Traits\WithActionValidate;
use LivewireKit\Contracts\Traits\WithLivewireRulePrefix;

abstract class Contract
{
    use WithActionValidate;
    use WithLivewireRulePrefix;
}
