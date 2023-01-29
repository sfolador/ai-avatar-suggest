<?php

use Illuminate\Support\Facades\Route;
use Sfolador\AiAvatarSuggest\Controllers\AiAvatarSuggestController;

Route::post('/ai-avatar-suggest', [AiAvatarSuggestController::class, 'suggest'])->name('ai-avatar-suggest');
