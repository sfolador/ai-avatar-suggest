<?php

namespace Sfolador\AiAvatarSuggest;

use OpenAI;
use Sfolador\AiAvatarSuggest\Commands\AiSuggestClearCache;
use Sfolador\AiAvatarSuggest\Middleware\AiAvatarSuggestThrottle;
use Sfolador\AiAvatarSuggest\Services\AiService;
use Sfolador\AiAvatarSuggest\Services\AiServiceInterface;
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
            ->hasViews()
            ->hasRoutes('ai_avatar_suggest_routes')
            ->hasCommand(AiSuggestClearCache::class);
    }

    public function registeringPackage(): void
    {
        $this->app->bind(AiServiceInterface::class, function () {
            $apiKey = config('ai-avatar-suggest.openai_key') ?? '';

            /** @phpstan-ignore-next-line  */
            $client = OpenAI::client($apiKey);

            return new AiService($client);
        });

        $this->app->bind(AiAvatarSuggestInterface::class, function () {
            /**
             * @var AiServiceInterface $aiAvatarSuggestInterface
             */
            $aiAvatarSuggestInterface = app(AiServiceInterface::class);

            return new AiAvatarSuggest($aiAvatarSuggestInterface);
        });

        app('router')->aliasMiddleware('ai-suggest-throttle', AiAvatarSuggestThrottle::class);
    }
}
