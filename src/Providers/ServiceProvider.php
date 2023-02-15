<?php

namespace Ja\Livewire\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Livewire\Livewire;

use Ja\Livewire\View\Compilers\BladeTagCompiler;
use Ja\Livewire\View\Compilers\PascalTagCompiler;
use Ja\Livewire\View\Components\Element;
use Ja\Livewire\Support\Blade as JaBladeHelper;
use Ja\Livewire\View\Components as JaLivewireComponents;
use Ja\Livewire\Livewire as JaLivewire;

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
        Blade::componentNamespace(JaLivewireComponents::class, 'jal');

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
        $compiler = $this->app['blade.compiler'];

        if (method_exists($compiler, 'precompiler')) {
            $compiler->precompiler(fn ($string) => app(BladeTagCompiler::class)->compile($string));
            $compiler->precompiler(fn ($string) => app(PascalTagCompiler::class)->compile($string));
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

            $aliases = [
                \JL::class => \Ja\Livewire\Support\Helper::class,
                \Tailwind::class => \Ja\Livewire\Support\Tailwind::class,
            ];

            collect($aliases)->map(fn ($class, $namespace) => (
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
