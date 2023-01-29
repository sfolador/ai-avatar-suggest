<?php

namespace Sfolador\AiAvatarSuggest;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AiAvatarSuggestServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('ai-avatar-suggest')
            ->hasConfigFile()
            ->hasRoutes('ai_avatar_suggest_routes');
    }

    public function registeringPackage()
    {
        $this->app->bind(AiAvatarSuggestInterface::class, function () {
            return new AiAvatarSuggest();
        });
    }
}
