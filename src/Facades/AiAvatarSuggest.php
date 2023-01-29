<?php

namespace Sfolador\AiAvatarSuggest\Facades;

use Illuminate\Support\Facades\Facade;
use Sfolador\AiAvatarSuggest\AiAvatarSuggestFake;
use Sfolador\AiAvatarSuggest\AiAvatarSuggestInterface;

/**
 * @see \Sfolador\AiAvatarSuggest\AiAvatarSuggest
 */
class AiAvatarSuggest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AiAvatarSuggestInterface::class;
    }

public static function fake()
{
    static::swap(new AiAvatarSuggestFake());
}
}
