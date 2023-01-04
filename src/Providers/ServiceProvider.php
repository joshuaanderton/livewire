<?php

namespace TallStackApp\Tools\Providers;

use TallStackApp\Tools\Blade as TallBlade;
use TallStackApp\Tools\Livewire as TallLivewire;

use Livewire\Livewire;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerClassAliases();
    }

    public function boot()
    {
        $this
            ->loadRoutes()
            ->loadTranslations()
            ->loadViews()
            ->loadBladeComponents()
            ->loadLivewireComponents();
    }

    private function loadRoutes()
    {
        $this->loadRoutesFrom(
            $this->path('routes/routes.php')
        );

        return $this;
    }

    private function loadTranslations()
    {
        $this->loadTranslationsFrom(
            $this->path('lang'),
            'tall'
        );

        return $this;
    }

    private function loadBladeComponents(): self
    {
        Blade::componentNamespace(TallBlade::class, 'tall');

        return $this;
    }

    private function loadLivewireComponents(): self
    {
        collect([
            'notifications' => TallLivewire\Notifications::class,
        ])->each(fn ($class, $key) => (
            Livewire::component("tall-{$key}", $class)
        ));

        return $this;
    }

    private function loadViews(): self
    {
        $this->loadViewsFrom(
            $this->path('resources/views'),
            'tall'
        );

        return $this;
    }

    public function registerClassAliases(): self
    {
        $this->app->booting(function ($app) {
            $loader = AliasLoader::getInstance();

            collect([

                // Old namespace
                \Ja\Tall\Blade::class                     => \TallStackApp\Tools\Blade::class,
                \Ja\Tall\Blade\Traits\CssClassable::class => \TallStackApp\Tools\Blade\Traits\CssClassable::class,
                \Ja\Tall\Blade\Traits\Mergeable::class    => \TallStackApp\Tools\Blade\Traits\Mergeable::class,
                \Ja\Tall\Blade\Traits\Routable::class     => \TallStackApp\Tools\Blade\Traits\Routable::class,
                \Ja\Tall\Blade\Traits\Translatable::class => \TallStackApp\Tools\Blade\Traits\Translatable::class,
                \Ja\Tall\Blade\Traits\WithHooks::class    => \TallStackApp\Tools\Blade\Traits\WithHooks::class,
                \Ja\Tall\Support\Helper::class            => \TallStackApp\Tools\Support\Helper::class,

                // Helper class
                \Tall::class                              => \TallStackApp\Tools\Support\Helper::class,
                
            ])->map(fn ($class, $namespace) => (
                $loader->alias(
                    $namespace,
                    $class
                )
            ));
        });

        return $this;
    }

    private function path(...$append): string
    {
        $path = Str::remove('/src/Providers', __DIR__);

        return join('/', [$path, ...$append]);
    }
}
