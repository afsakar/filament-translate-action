<?php

use Afsakar\FilamentTranslateAction\Helpers\GoogleTranslate;
use Filament\Forms\Components\Field;
use Filament\Notifications\Notification;

if (! function_exists('getLangs')) {
    function getLangs()
    {
        return match (config('filament-translate-action.laravellocalization')) {
            true => collect(config('laravellocalization.supportedLocales'))->mapWithKeys(fn ($locale, $key) => [$key => $locale['native']])->toArray(),
            default => config('filament-translate-action.locales'),
        };
    }
}

if (! function_exists('translate_text')) {
    function translate_text(Field $component, string $source, string $target, string $text): string
    {
        $googleTranslate = new GoogleTranslate;

        try {
            $text = null;

            if (class_exists('FilamentTiptapEditor\TiptapEditor') && $component instanceof \FilamentTiptapEditor\TiptapEditor) {
                match (data_get($component->getOutput(), 'value')) {
                    'json' => $text = tiptap_converter()->asJSON($component->getState()), // @phpstan-ignore-line
                    'text' => $text = tiptap_converter()->asText($component->getState()), // @phpstan-ignore-line
                    default => $text = tiptap_converter()->asHTML($component->getState()), // @phpstan-ignore-line
                };
            } else {
                $text = $component->getState();
            }

            $googleTranslate = $googleTranslate->translate($source, $target, $text);

            return $googleTranslate;

        } catch (\Exception $exception) {
            Notification::make()
                ->title(__('filament-translate-action::filament-translate-action.error_title'))
                ->body(__('filament-translate-action::filament-translate-action.error_message') . '<br/>' . $exception->getMessage())
                ->danger()
                ->send();

            return $component->getState();
        }
    }
}
