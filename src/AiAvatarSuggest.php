<?php

namespace Sfolador\AiAvatarSuggest;

use Illuminate\Support\Str;
use OpenAI;

class AiAvatarSuggest implements AiAvatarSuggestInterface
{
    private OpenAI\Client $client;

    private string|null $suggestion;

    private string $prompt;

    public function __construct()
    {
        $this->client = OpenAI::client(config('ai-avatar-suggest.openai_key'));
    }

    private function getSuggestion()
    {
        $response = $this->client->images()->create([
            'prompt' => $this->prompt,
            'n' => 1,
            'size' => config('ai-avatar-suggest.default_size'),
            'response_format' => 'url',
        ]);

        $this->suggestion = Str::of(collect($response->data)->first()->url)->value();
    }

    public function suggest(string $prompt): string|null
    {
        $this->prompt = $prompt;
        $this->getSuggestion();

        if ($this->hasSuggestion()) {
            return $this->suggestion;
        }

        return null;
    }

    public function hasSuggestion(): bool
    {
        return $this->suggestion !== null;
    }
}
