<?php

namespace Afsakar\FilamentTranslateAction\Actions;

use Afsakar\FilamentTranslateAction\Helpers\GoogleTranslate;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TranslatableAction
{
    public static function make(): void
    {
        Field::macro('translatable', function () {
            // @phpstan-ignore-next-line
            return $this->hintAction(
                function (Field $component) {
                    return Action::make('google_translate')
                        ->icon('heroicon-o-language')
                        ->label(__('filament-translate-action::filament-translate-action.modal_title'))
                        ->slideOver()
                        ->hidden(function () use ($component) {
                            return $component->getState() === null;
                        })
                        ->form([
                            Select::make('source')
                                ->label(__('filament-translate-action::filament-translate-action.source'))
                                ->options(fn () => getLangs())
                                ->reactive()
                                ->searchable()
                                ->default((string) config('app.locale')),
                            Select::make('target')
                                ->label(__('filament-translate-action::filament-translate-action.target'))
                                ->options(fn ($get) => collect(getLangs())
                                    ->filter(fn ($locale, $key) => $key != $get('source'))
                                    ->toArray())
                                ->reactive()
                                ->searchable(),
                            Placeholder::make('preview')
                                ->label(__('filament-translate-action::filament-translate-action.original_content'))
                                ->content(fn () => new HtmlString($component->getState()))
                                ->disabled(),
                            Group::make()
                                ->visible(fn ($get) => $get('source') && $get('target'))
                                ->schema([
                                    Placeholder::make('translated')
                                        ->label(__('filament-translate-action::filament-translate-action.translated_content'))
                                        ->content(function ($get) use ($component) {
                                            $translated_text = translate_text($component, $get('source'), $get('target'), $component->getState());

                                            return new HtmlString($translated_text);
                                        }),
                                ]),
                        ])
                        ->modalSubmitActionLabel(__('filament-translate-action::filament-translate-action.translate'))
                        ->action(function (array $data, $livewire) use ($component) {
                            $googleTranslate = new GoogleTranslate;

                            $source = $data['source'] ?: (string) config('app.locale');

                            try {
                                $googleTranslate = translate_text($component, $source, $data['target'], $component->getState());
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
