<?php

namespace Sfolador\AiAvatarSuggest\Services;

use OpenAI\Responses\Images\CreateResponse;

interface AiServiceInterface
{
    public function getSuggestion(string $prompt): ?CreateResponse;
}
