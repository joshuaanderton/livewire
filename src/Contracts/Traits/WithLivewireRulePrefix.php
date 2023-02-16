<?php

namespace LivewireKit\Contracts\Traits;

use Illuminate\Support\Str;

trait WithLivewireRulePrefix
{
    protected static function removePrefix(array $data): array
    {
        return collect($data)
                    ->map(fn ($value, $fieldName) => [array_reverse(explode('.', $fieldName))[0] => $value])
                    ->collapse()
                    ->all();
    }

    protected static function modelPrefix(): string
    {
        $contractClass = get_called_class();                  // e.g. App\Contracts\TaskContract
        $modelName = class_basename($contractClass);      // TaskTemplateContract
        $modelName = Str::remove('Contract', $modelName); // TaskTemplate
        $modelName = Str::lcfirst($modelName);            // taskTemplate
        $prefix = "{$modelName}.";                     // taskTemplate. (e.g. taskTemplate.title)

        return $prefix;
    }
}
