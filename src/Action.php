<?php

namespace LivewireKit;

use Lorisleiva\Actions\Concerns\AsCommand;
use Lorisleiva\Actions\Concerns\AsController;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsListener;
use Lorisleiva\Actions\Concerns\AsObject;

class Action
{
    use AsController;
    use AsObject;
    use AsJob;
    // use AsCommand;
    // use AsListener;
    // use AsFake;
}
