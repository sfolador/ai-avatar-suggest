<?php

namespace Sfolador\AiAvatarSuggest\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;
use Sfolador\AiAvatarSuggest\Requests\AvatarRequest;

class AiAvatarSuggestController extends Controller
{
    public function suggest(AvatarRequest $request): JsonResponse
    {
        $prompt = $request->get('prompt');
        /* @phpstan-ignore-next-line */
        $suggestion = AiAvatarSuggest::suggest($prompt);

        return response()->json([
            'suggestion' => $suggestion,
        ]);
    }
}
