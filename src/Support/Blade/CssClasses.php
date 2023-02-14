<?php declare (strict_types=1);

namespace Ja\Livewire\Support\Blade;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

final class CssClasses
{
    public static function compiled(string $cssFileName = 'resources/css/app.css'): ?Collection
    {
        $cssClassGroups = Cache::get('jal-compiled-css-classes', function () use ($cssFileName): array|null {
            $buildPath = base_path('public/build');
    
            if (! $assetManifest = File::get("{$buildPath}/manifest.json")) {
                return null;
            }
    
            $assetManifest = json_decode($assetManifest, true);
            $cssFileRef = (
                $assetManifest[$cssFileName] ??
                $assetManifest[Str::replace('resources/css', 'resources/js', $cssFileName)] ??
                null
            );
    
            if (! $cssFileRef) {
                return null;
            }
    
            $css = File::get("{$buildPath}/{$cssFileRef['file']}");
            $cssClasses = Str::matchAll('((\.([a-z][a-z0-9-_\\\\:]*))[,{])', $css);
            $cssClassGroups = ['default' => []];
            
            foreach ($cssClasses as $cssClass) {
                $groupKey = 'default';
                $cssClassValue = $cssClass;
    
                if (Str::contains($cssClass, '\:')) {
                    $groupKey = ltrim(explode('\:', $cssClass)[0], '.');
                    $cssClassValue = explode('\:', $cssClass)[1];
                }
    
                // Remove psuedos from class name
                $cssClassValue = explode(':', $cssClassValue)[0];
    
                $cssClassGroups[$groupKey] = array_merge(
                    $cssClassGroups[$groupKey] ?? [],
                    [$cssClassValue]
                ); 
            }
            
            Cache::put('jal-compiled-css-classes', $cssClassGroups);

            return $cssClassGroups;
        });

        return new Collection($cssClassGroups);
    }
}