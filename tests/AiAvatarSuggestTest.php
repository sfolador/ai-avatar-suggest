<?php

use function Pest\Laravel\post;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;

beforeEach(function () {
    $this->prompt = 'text@example.com';
    config()->set('ai-email-suggest.openai_key', 'test_api_key');
});

it('can suggest an avatar', function () {
    AiAvatarSuggest::fake();

    $suggestion = AiAvatarSuggest::suggest('draw a developer with a laptop');
    $this->expect($suggestion)->toBe('https://www.google.com');
});

it('should suggest a correct url', function () {
    $initialInput = 'draw a developer with a laptop';
    config()->set('ai-avatar-suggest.openai_key', 'test_api_key');

    $mocked = \Pest\Laravel\mock(\Sfolador\AiAvatarSuggest\AiAvatarSuggest::class)
        ->shouldReceive('suggest')
        ->withArgs([$initialInput])
        ->andReturn('https://www.google.com')->getMock();

    $results = $mocked->suggest($initialInput);
    $this->expect($results)->toBe('https://www.google.com');
});

it('should return a suggestion from a controller', function () {
    $initialInput = 'draw a developer with a laptop';
    AiAvatarSuggest::fake();

    $response = post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertOk();

    $this->expect($response->json('suggestion'))->toBe('https://www.google.com');
});
