<?php

namespace Sfolador\AiAvatarSuggest;

class AiAvatarSuggestFake implements AiAvatarSuggestInterface
{

    public function suggest(string $prompt): string|null
    {
        return "https://www.google.com";
    }
}
