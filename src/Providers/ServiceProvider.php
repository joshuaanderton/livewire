<?php

namespace TallStackApp\Tools\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    private string $path = __DIR__ . '/../..';

    public function register()
    {
        $this
            ->registerClassAliases();
    }

    public function boot()
    {
        $this
            ->loadRoutes()
            ->loadTranslations()
            ->loadViews()
            ->loadComponents();
    }

    private function loadRoutes()
    {
        $this->loadRoutesFrom(
            "{$this->path}/routes/routes.php"
        );

        return $this;
    }

    private function loadTranslations()
    {
        $this->loadTranslationsFrom(
            "{$this->path}/lang",
            'tall'
        );

        return $this;
    }

    private function loadComponents(): self
    {
        Blade::componentNamespace(
            'Ja\\Tall\\Blade',
            'tall'
        );

        return $this;
    }

    private function loadViews(): self
    {
        $this->loadViewsFrom(
            "{$this->path}/resources/views",
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
}
