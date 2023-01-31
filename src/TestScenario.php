<?php declare (strict_types=1);

namespace Ja\Livewire;

abstract class TestScenario
{
    /**
     * @param array<array, string> data
     * @return array<mixed, int>
     */
    abstract public function handle(array $data = []): array;

    public static function make(array $data = []): array
    {
        $class = get_called_class();
        return (new $class)->handle($data);
    }
}