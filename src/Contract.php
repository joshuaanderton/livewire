<?php

namespace TallStackApp\Tools;

use TallStackApp\Tools\Contracts\Traits\WithActionValidate;
use TallStackApp\Tools\Contracts\Traits\WithLivewireRulePrefix;

abstract class Contract
{
    use WithActionValidate,
        WithLivewireRulePrefix;
}