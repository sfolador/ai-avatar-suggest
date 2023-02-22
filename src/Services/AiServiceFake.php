<?php

namespace Sfolador\AiAvatarSuggest\Services;

use OpenAI\Responses\Images\CreateResponse;

class AiServiceFake implements AiServiceInterface
{
    public function getSuggestion(string $prompt): ?CreateResponse
    {
        return CreateResponse::from(
            [
                'id' => '1',
                'created' => 1,
                'data' => [
                    [
                        'url' => 'https://example.com',
                    ],
                ],
            ]
        );
    }
}
