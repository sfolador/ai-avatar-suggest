<?php

namespace Sfolador\AiAvatarSuggest\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;

class AiAvatarSuggestController extends Controller
{
    public function suggest(Request $request){
        $prompt = $request->get('prompt');
        $suggestion = AiAvatarSuggest::suggest($prompt);
        return response()->json([
            'suggestion' => $suggestion,
        ]);
    }
}
