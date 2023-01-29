<?php

namespace Sfolador\AiAvatarSuggest;

interface AiAvatarSuggestInterface
{
    public function suggest(string $prompt): string|null;

}
