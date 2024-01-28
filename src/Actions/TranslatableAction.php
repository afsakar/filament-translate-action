<?php

namespace Afsakar\FilamentTranslateAction\Actions;

use Afsakar\FilamentTranslateAction\Helpers\GoogleTranslate;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class TranslatableAction
{
    public static function make(): void
    {
        Field::macro('translatable', function () {
            return $this->hintAction(
                function (Field $component) {
                    return Action::make('google_translate')
                        ->icon('heroicon-o-language')
                        ->label(__('filament-translate-action::filament-translate-action.modal_title'))
                        ->form([
                            Select::make('source')
                                ->label(__('filament-translate-action::filament-translate-action.source'))
                                ->options(fn () => getLangs())
                                ->searchable()
                                ->default((string) config('app.locale')),
                            Select::make('target')
                                ->label(__('filament-translate-action::filament-translate-action.target'))
                                ->options(fn () => getLangs())
                                ->searchable()
                                ->default((string) config('app.locale')),
                        ])
                        ->modalSubmitActionLabel(__('filament-translate-action::filament-translate-action.translate'))
                        ->action(function (array $data, $livewire) use ($component) {
                            $googleTranslate = new GoogleTranslate();

                            $source = $data['source'] ?: (string) config('app.locale');

                            $text = null;

                            if (class_exists('FilamentTiptapEditor\TiptapEditor') && $component instanceof \FilamentTiptapEditor\TiptapEditor) {
                                match (data_get($component->getOutput(), 'value')) {
                                    'json' => $text = tiptap_converter()->asJSON($component->getState()),
                                    'text' => $text = tiptap_converter()->asText($component->getState()),
                                    default => $text = tiptap_converter()->asHTML($component->getState()),
                                };
                            } else {
                                $text = $component->getState();
                            }

                            try {
                                $googleTranslate = $googleTranslate->translate($source, $data['target'], $text);
                                $component->state($googleTranslate);

                                $livewire->dispatch('refresh-tiptap-editors', [
                                    'statePath' => $component->getName(),
                                    'content' => $googleTranslate,
                                ]);

                                Notification::make()
                                    ->title(__('filament-translate-action::filament-translate-action.success_title'))
                                    ->body(__('filament-translate-action::filament-translate-action.success_message'))
                                    ->success()
                                    ->send();
                            } catch (\Exception $exception) {
                                Notification::make()
                                    ->title(__('filament-translate-action::filament-translate-action.error_title'))
                                    ->body(__('filament-translate-action::filament-translate-action.error_message') . '<br/>' . $exception->getMessage())
                                    ->danger()
                                    ->send();

                                return $component->getState();
                            }
                        });
                }
            );
        });
    }
}
