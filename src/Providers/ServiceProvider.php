<?php

namespace LivewireKit\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Livewire\Livewire;

use LivewireKit\View\Compilers\BladeTagCompiler;
use LivewireKit\View\Compilers\PascalTagCompiler;
use LivewireKit\View\Components as LivewireKitComponents;
use LivewireKit\Livewire as LivewireKit;

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
        Blade::componentNamespace(LivewireKitComponents::class, 'jal');
        Blade::componentNamespace(LivewireKitComponents::class, 'kit');

        return $this;
    }

    private function loadLivewireComponents(): self
    {
        collect([
            'notifications' => LivewireKit\Notifications::class,
        ])->each(fn ($class, $key) => (
            collect([
                "jal-{$key}",
                "kit-{$key}"
            ])->each(fn ($alias) => Livewire::component($alias, $class))
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
            'livewirekit'
        );

        return $this;
    }

    public function registerClassAliases(): self
    {
        $this->app->booting(function ($app) {
            
            $loader = AliasLoader::getInstance();

            $deprecated = [
                \Ja\Livewire\Blade\Traits\Translatable::class => \LivewireKit\View\Traits\Translatable::class,
                \Ja\Livewire\Blade\Traits\Routable::class => \LivewireKit\View\Traits\Routable::class,
                \Ja\Livewire\Blade\Traits\Mergeable::class => \LivewireKit\View\Traits\Mergeable::class,
                \Ja\Livewire\Blade\Traits\CssClassable::class => \LivewireKit\View\Traits\CssClassable::class,
                
                \Ja\Livewire\Blade::class,
                \Ja\Livewire\Providers\ServiceProvider::class,
                \Ja\Livewire\View\Traits\Translatable::class,
                \Ja\Livewire\View\Traits\Routable::class,
                \Ja\Livewire\View\Traits\Mergeable::class,
                \Ja\Livewire\View\Traits\CssClassable::class,
                \Ja\Livewire\Livewire\Notifications::class,
            ];

            $aliases = [
                \Kit::class => \LivewireKit\Support\Helper::class,
                \Tailwind::class => \LivewireKit\Support\Tailwind::class,

                // Deprecating
                \JL::class => \LivewireKit\Support\Helper::class,
            ];

            $aliases = (
                (new Collection($deprecated))
                    ->map(fn ($value, $key) => is_int($key)
                        ? [$value => Str::replace('Ja\\Livewire', 'LivewireKit', $value)]
                        : [$key => $value]
                    )
                    ->collapse()
                    ->merge($aliases)
            );

            $aliases->map(fn ($class, $namespace) => (
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
