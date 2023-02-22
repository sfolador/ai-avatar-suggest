<?php

namespace Sfolador\AiAvatarSuggest\Facades;

use Illuminate\Support\Facades\Facade;
use Sfolador\AiAvatarSuggest\Services\AiServiceFake;
use Sfolador\AiAvatarSuggest\Services\AiServiceInterface;

class AiService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AiServiceInterface::class;
    }

    public static function fake(): void
    {
        static::swap(new AiServiceFake());
    }
}
