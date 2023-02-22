<?php

use function Pest\Laravel\post;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;

it('should return a suggestion', function () {
    $initialInput = 'https://www.google.com';
    AiAvatarSuggest::fake();

    $response = post(route('ai-avatar-suggest'), ['prompt' => 'prompt'])->assertOk();

    expect($response->json('suggestion'))
        ->toBe($initialInput);
});

it('validates the prompt', function () {
    $initialInput = [];

    AiAvatarSuggest::fake();

    post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertInvalid(['prompt']);
    post(route('ai-avatar-suggest'), ['prompt' => null])
        ->assertInvalid(['prompt' => 'required']);
});

it('requires a prompt', function () {
    AiAvatarSuggest::fake();
    post(route('ai-avatar-suggest'), ['prompt' => null])
        ->assertInvalid(['prompt' => 'required']);
});

it('should not throttle requests if throttle is disabled', function () {
    config()->set('ai-avatar-suggest.throttle.enabled', false);
    $initialInput = 'asd';
    AiAvatarSuggest::fake();

    post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertOk();
});

it('should throttle requests', function () {
    config()->set('ai-avatar-suggest.throttle.enabled', true);
    config()->set('ai-avatar-suggest.throttle.max_attempts', 2);
    $initialInput = 'https://www.google.com';
    AiAvatarSuggest::fake();

    post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertOk();
    post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertOk();
    post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertStatus(429); //too many requests, fix for github actions.
});
