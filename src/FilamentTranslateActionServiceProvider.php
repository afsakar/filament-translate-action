<?php

namespace Afsakar\FilamentTranslateAction;

use Afsakar\FilamentTranslateAction\Actions\TranslatableAction;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTranslateActionServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-translate-action';

    public static string $viewNamespace = 'filament-translate-action';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('afsakar/filament-translate-action');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }
    }

    public function bootingPackage()
    {
        TranslatableAction::make();
    }

    protected function getAssetPackageName(): ?string
    {
        return 'afsakar/filament-translate-action';
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament-translate-action_table',
        ];
    }
}
