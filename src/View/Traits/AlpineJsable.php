<?php declare (strict_types=1);

namespace LivewireKit\View\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Js;
use Illuminate\Support\Collection;

trait AlpineJsable
{
    public ?string $xData;

    private function parseXData($xData): string|null
    {
        if (is_array($xData)) {

            $xData = Js::from(
                (new Collection($xData))
                    ->map(function ($value, $key) {

                        $value = trim($value);
                        $value = preg_replace( "/\r|\n/", '', $value);

                        if (is_numeric($key)) {
                            return $value; // e.g. init(){...}
                        }

                        $boolOrNull = ['true' => true, 'false' => false, 'null' => null];

                        if (isset($boolOrNull[$value])) {
                            $value = $boolOrNull[$value];
                        } elseif (is_numeric($value) && Str::contains($value, '.')) {
                            $value = (float) $value;
                        } elseif (is_numeric($value)) {
                            $value = (int) $value;
                        } elseif (Str::endsWith($value, '}') || Str::endsWith($value, ')')) {
                            $value = $value; // Don't wrap with quotes
                        } else {
                            $value = '"' . (string) $value . '"';
                        }

                        return "{$key}: {$value}"; // e.g. key: "string"|1|true|() => {}
                    })
                    ->values()
                    ->join(', ')
            );
        }

        return is_string($xData) ? $xData : null;
    }
}