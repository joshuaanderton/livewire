<?php

namespace Ja\Livewire\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;
use Ja\Livewire\Blade as JaBlade;
use Ja\Livewire\Livewire as JaLivewire;
use Ja\Livewire\Support\TagCompiler;
use Livewire\Livewire;

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
            ->loadLivewireComponents()
            ->loadCustomTagCompiler();
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
            'ja_livewire'
        );

        return $this;
    }

    private function loadBladeComponents(): self
    {
        Blade::componentNamespace(JaBlade::class, 'jal');

        return $this;
    }

    private function loadLivewireComponents(): self
    {
        collect([
            'notifications' => JaLivewire\Notifications::class,
        ])->each(fn ($class, $key) => (
            Livewire::component("jal-{$key}", $class)
        ));

        return $this;
    }

    protected function loadCustomTagCompiler(): self
    {
        if (method_exists($this->app['blade.compiler'], 'precompiler')) {
            $this->app['blade.compiler']->precompiler(function ($string) {
                return app(TagCompiler::class)->compile($string);
            });
        }

        return $this;
    }

    private function loadViews(): self
    {
        $this->loadViewsFrom(
            $this->path('resources/views'),
            'ja-livewire'
        );

        return $this;
    }

    public function registerClassAliases(): self
    {
        $this->app->booting(function ($app) {
            $loader = AliasLoader::getInstance();

            collect([
                \JL::class => \Ja\Livewire\Support\Helper::class,
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
