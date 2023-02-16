<?php declare (strict_types=1);

namespace LivewireKit\View\Components;

use Illuminate\Support\Facades\Lang;
use LivewireKit\Blade as Component;
use LivewireKit\View\Traits\Translatable;

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
    public function __construct(
        string $heading = null,
        string $text = null,
        bool $persist = null,
        bool $success = null,
        bool $error = null
    ) {
        $this->heading = $heading;
        $this->text = $text;
        $this->persist = ! ! $persist;
        $this->error = ! ! $error;
        $this->success = ! ! $success;

        if (! $this->heading) {
            if ($this->error) {
                $this->heading = Lang::has('shared.error') ? Lang::get('shared.error') : __('Error');
            } elseif ($this->success) {
                $this->heading = Lang::has('shared.success') ? Lang::get('shared.success') : __('Success!');
            } else {
                $this->heading = Lang::has('shared.notification') ? Lang::get('shared.notification') : __('Notification');
            }
        }
    }
}
