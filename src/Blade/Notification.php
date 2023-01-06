<?php

namespace TallStackApp\Tools\Blade;

use TallStackApp\Tools\Blade\Traits\Translatable;
use TallStackApp\Tools\Blade as Component;

class Notification extends Component
{
    use Translatable;

    protected array $translatable = ['heading', 'text'];

    public ?string $heading;

    public ?string $text;

    public bool $persist;

    public bool $success;

    public bool $error;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $heading = null, string $text = null, bool $persist = null, bool $success = null, bool $error = null)
    {
        $this->heading = $heading;
        $this->text = $text;
        $this->persist = ! ! $persist;
        $this->error = ! ! $error;
        $this->success = ! ! $success;

        if (! $this->heading) {
            if ($this->error) {
                $this->heading = 'shared.error';
            } elseif ($this->success) {
                $this->heading = 'shared.success';
            } else {
                $this->heading = 'shared.info';
            }
        }
    }
}
