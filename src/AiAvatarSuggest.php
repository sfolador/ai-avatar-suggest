<?php

namespace Sfolador\AiAvatarSuggest;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use OpenAI\Responses\Images\CreateResponse;
use Sfolador\AiAvatarSuggest\Services\AiServiceInterface;

class AiAvatarSuggest implements AiAvatarSuggestInterface
{
    private string|null $suggestion = null;

    private string $description;

    public function __construct(private readonly AiServiceInterface $aiService)
    {
    }

    private function retrieveSuggestion(): string|null
    {
        $response = $this->aiService->getSuggestion($this->createPrompt($this->description));

        $suggestion = $this->extractFirstChoice($response);
        if ($suggestion === '') {
            return $this->suggestion;
        }

        $this->saveSuggestion($this->description, $suggestion);
        $this->suggestion = $suggestion;

        return $this->suggestion;
    }

    private function extractFirstChoice(?CreateResponse $response): string
    {
        if (! $response) {
            return '';
        }

        if ($response->data[0]?->url === '') {
            return '';
        }

        return $response->data[0]?->url;
    }

    public function createPrompt(string $description): string
    {
        return view('ai-avatar-suggest::prompt', [
            'prompt' => $description,
        ])->render();
    }

    public function suggest(string $prompt): string|null
    {
        $this->description = $prompt;

        if ($this->suggestionAlreadySeen($this->description)) {
            /** @phpstan-ignore-next-line  */
            $this->suggestion = $this->cachedSuggestionFor($this->description);

            return $this->suggestion;
        }

        return $this->retrieveSuggestion();
    }

    public function suggestionAlreadySeen(string $description): bool
    {
        if (! config('ai-avatar-suggest.use_cache')) {
            return false;
        }

        if (Cache::supportsTags()) {
            return Cache::tags('ai-avatar-suggest')->has($this->getCacheKey($description));
        }

        return Cache::has($this->getCacheKey($description));
    }

    public function saveSuggestion(string $description, string $suggestion): void
    {
        if (config('ai-avatar-suggest.use_cache')) {
            if (Cache::supportsTags()) {
                Cache::tags('ai-avatar-suggest')->forever($this->getCacheKey($description), $suggestion);

                return;
            }
            Cache::forever($this->getCacheKey($description), $suggestion);
        }
    }

    private function cachedSuggestionFor(string $description): mixed
    {
        return Cache::get($this->getCacheKey($description));
    }

    private function getCacheKey(string $description): string
    {
        return 'ai-avatar-suggest-'.Str::slug($description);
    }
}
