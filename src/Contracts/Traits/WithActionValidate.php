<?php

namespace Ja\Livewire\Contracts\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait WithActionValidate
{
    /**
     * Validate rules for provided action
     *
     * @var string $action
     * @var array $data
     * @var array ...$arguments 
     * @return array|ValidationException
     */
    public static function validate(string $action, array $data, ...$arguments): array|ValidationException
    {
        $contractClass = get_called_class(); // e.g. App\Contracts\TaskContract
        $customAttributes = $arguments['customAttributes'] ?? [];

        $rules = count($arguments)
            ? (new $contractClass)->$action(...$arguments)
            : (new $contractClass)->$action();

        // if ($prefix = explode('.', array_keys($data)[0])[0] ?? false) {
        //     $customAttributes = collect($rules)
        //         ->keys()
        //         ->map(fn ($fieldName) => [$fieldName => Str::remove("{$prefix}.", $fieldName)])
        //         ->collapse()
        //         ->all();
        // }

        if ($prefix = explode('.', array_keys($data)[0])[0] ?? false) {
            $data = self::removePrefix($data);
            $rules = self::removePrefix($rules);

            $customAttributes = collect($rules)
                ->keys()
                ->map(fn ($fieldName) => [$fieldName => "{$prefix}.{$fieldName}"])
                ->collapse()
                ->all();
        }
        
        Validator::make($data, $rules, [], $customAttributes)->validate();


        return $data;
    }
}