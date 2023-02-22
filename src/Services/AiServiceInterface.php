<?php

namespace Sfolador\AiAvatarSuggest\Services;

use OpenAI\Responses\Completions\CreateResponse;

interface AiServiceInterface
{
    public function getSuggestion(string $prompt): ?CreateResponse;
}
