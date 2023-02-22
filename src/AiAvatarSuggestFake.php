<?php

namespace Sfolador\AiAvatarSuggest;

class AiAvatarSuggestFake implements AiAvatarSuggestInterface
{
    public function suggest(string $prompt): string|null
    {
        return $prompt;
    }

    public function createPrompt(string $prompt): string
    {
        return view('ai-avatar-suggest::prompt', [
            'prompt' => $prompt,
        ])->render();
    }
}
