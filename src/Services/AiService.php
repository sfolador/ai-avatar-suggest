<?php

namespace Sfolador\AiAvatarSuggest\Services;

use OpenAI;
use OpenAI\Responses\Images\CreateResponse;

class AiService implements AiServiceInterface
{
    public function __construct(private readonly OpenAI\Client $client)
    {
    }

    public function getSuggestion(string $prompt): ?CreateResponse
    {
        return  $this->client->images()->create([
            'prompt' => $prompt,
            'n' => 1,
            'size' => config('ai-avatar-suggest.default_size'),
            'response_format' => 'url',
        ]);
    }
}
