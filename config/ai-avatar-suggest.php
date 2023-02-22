<?php

// config for Sfolador/AiAvatarSuggest
return [
    'openai_key' => env('OPENAI_KEY'),
    'default_size' => '256x256',
    'default_route' => 'ai-avatar-suggest',
    'use_cache' => true,
    'throttle' => [
        'enabled' => false,
        'max_attempts' => 60,
        'prefix' => 'ai-avatar-suggest',
    ],
];
