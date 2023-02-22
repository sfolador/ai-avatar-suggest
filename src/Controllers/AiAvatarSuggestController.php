<?php

namespace Sfolador\AiAvatarSuggest\Controllers;

use Illuminate\Routing\Controller;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;
use Sfolador\AiAvatarSuggest\Requests\AvatarRequest;

class AiAvatarSuggestController extends Controller
{
    public function suggest(AvatarRequest $request)
    {
        $prompt = $request->get('prompt');
        $suggestion = AiAvatarSuggest::suggest($prompt);

        return response()->json([
            'suggestion' => $suggestion,
        ]);
    }
}
