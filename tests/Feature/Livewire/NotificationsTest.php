<?php

namespace Ja\Livewire\Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ja\Livewire\Livewire\Notifications;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Notifications::class);

        $component->assertStatus(200);
    }
}
