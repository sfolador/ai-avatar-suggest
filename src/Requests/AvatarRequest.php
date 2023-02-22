<?php

namespace Sfolador\AiAvatarSuggest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
{
    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'prompt' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
