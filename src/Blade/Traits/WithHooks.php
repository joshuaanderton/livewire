<?php

namespace TallStackApp\Tools\Blade\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

trait WithHooks
{
    protected array $hooks = [
        'data',
    ];

    public function __call($name, $arguments)
    {
        if (!in_array($name, $this->hooks)) {
            return $this->$name(...$arguments);
        }

        $hookSuffix = Str::ucfirst($name);

        if (($hookMethods = $this->extractHookMethods("before{$hookSuffix}"))->count() > 0) {
            $hookMethods->map(fn ($hookMethod) => (
                $this->$hookMethod(...$arguments)
            ));
        }

        if (($hookMethods = $this->extractHookMethods("after{$hookSuffix}"))->count() > 0) {

            $response = $this->$name(...$arguments);

            $hookMethods->map(fn ($hookMethod) => (
                $this->$hookMethod(...$arguments)
            ));

            return $response;
        }

        return $this->$name(...$arguments);
    }

    /**
     * Extract the hook methods for the component.
     *
     * @return array
     */
    protected function extractHookMethods(string $hookPrefix): Collection
    {
        return (
          collect((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PROTECTED))
              ->reject(fn (ReflectionMethod $method) => (
                  $method->isStatic()
              ))
              ->filter(fn (ReflectionMethod $method) => (
                  Str::startsWith($hookPrefix, $method)
              ))
              ->map(function (ReflectionMethod $method) {
                  return $method->getName();
              })
        );
    }
}