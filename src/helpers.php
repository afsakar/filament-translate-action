<?php

if (!function_exists('getLangs')) {
    function getLangs()
    {
        return match (config('filament-translate-action.laravellocalization')) {
            true => collect(config('laravellocalization.supportedLocales'))->mapWithKeys(fn($locale, $key) => [$key => $locale['native']])->toArray(),
            default => config('filament-translate-action.locales'),
        };
    }
}
