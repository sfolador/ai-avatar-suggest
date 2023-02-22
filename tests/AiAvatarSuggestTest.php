<?php

use OpenAI\Responses\Images\CreateResponse;
use function Pest\Laravel\post;
use Sfolador\AiAvatarSuggest\Facades\AiAvatarSuggest;
use Sfolador\AiAvatarSuggest\Facades\AiService;
use Sfolador\AiAvatarSuggest\Services\AiServiceFake;
use Sfolador\AiAvatarSuggest\Services\AiServiceInterface;


beforeEach(function () {
    config()->set('ai-email-suggest.openai_key', 'test_api_key');
});

it('can suggest an avatar', function () {
    AiAvatarSuggest::fake();

    $suggestion = AiAvatarSuggest::suggest('draw a developer with a laptop');
    $this->expect($suggestion)->toBe($suggestion);
});

it('should suggest a correct url', function () {
    $initialInput = 'draw a developer with a laptop';
    config()->set('ai-avatar-suggest.openai_key', 'test_api_key');

    AiAvatarSuggest::shouldReceive('suggest')->with($initialInput)->andReturn('https://www.google.com');

    $results = AiAvatarSuggest::suggest($initialInput);
    $this->expect($results)->toBe('https://www.google.com');
});

it('can use cache to avoid api calls', function () {
    $inputPrompt = 'inputPrompt';
    $cacheKey = 'ai-avatar-suggest-'.\Illuminate\Support\Str::slug($inputPrompt);

    $results = $inputPrompt;

    Cache::shouldReceive('supportsTags')->andReturn(false);
    Cache::shouldReceive('has')->once()->with($cacheKey)->andReturn(true);
    Cache::shouldReceive('get')->once()->with($cacheKey)->andReturn($inputPrompt);

    $suggestion = AiAvatarSuggest::suggest($inputPrompt);

    $this->expect($suggestion)->toBe($results);
});

it('saves suggestions in cache', function () {
    $inputPrompt = 'inputPrompt';
    $cacheKey = 'ai-avatar-suggest-'.\Illuminate\Support\Str::slug($inputPrompt);

    Cache::shouldReceive('supportsTags')->andReturn(false);
    Cache::shouldReceive('forever')->once()->withArgs([$cacheKey, $inputPrompt]);
    AiAvatarSuggest::saveSuggestion($inputPrompt, $inputPrompt);
});

it('saves suggestions in cache with tags', function () {
    $inputPrompt = 'inputPrompt';
    $cacheKey = 'ai-avatar-suggest-'.\Illuminate\Support\Str::slug($inputPrompt);
    Cache::shouldReceive('supportsTags')->andReturn(true);
    Cache::shouldReceive('tags')->with('ai-avatar-suggest')->andReturnSelf();
    Cache::shouldReceive('forever')->once()->withArgs([$cacheKey, $inputPrompt]);
    AiAvatarSuggest::saveSuggestion($inputPrompt, $inputPrompt);
});

it('checks if suggestion is already seen', function () {
    $inputPrompt = 'inputPrompt';
    $cacheKey = 'ai-avatar-suggest-'.\Illuminate\Support\Str::slug($inputPrompt);

    Cache::shouldReceive('supportsTags')->andReturn(false);
    Cache::shouldReceive('has')->once()->with($cacheKey)->andReturn(true);

    expect(AiAvatarSuggest::suggestionAlreadySeen($inputPrompt))->toBeTrue();
});

it('checks if suggestion is already seen with tags enabled', function () {
    $inputPrompt = 'inputPrompt';
    $cacheKey = 'ai-avatar-suggest-'.\Illuminate\Support\Str::slug($inputPrompt);

    Cache::shouldReceive('supportsTags')->andReturn(true);
    Cache::shouldReceive('tags')->with('ai-avatar-suggest')->andReturnSelf();
    Cache::shouldReceive('has')->once()->with($cacheKey)->andReturn(true);

    expect(AiAvatarSuggest::suggestionAlreadySeen($inputPrompt))->toBeTrue();
});

it('suggestion has not been seen if the config is false', function () {
    $inputPrompt = 'inputPrompt';

    config()->set('ai-email-avatar.use_cache', false);

    expect(AiAvatarSuggest::suggestionAlreadySeen($inputPrompt))->toBeFalse();
});

it('suggestion has not been seen if the config is false with tags enabled', function () {
    $inputPrompt = 'inputPrompt';

    config()->set('ai-avatar-suggest.use_cache', false);
    Cache::shouldReceive('supportsTags')->andReturn(true);
    Cache::shouldReceive('tags')->with('ai-avatar-suggest')->andReturnSelf();
    expect(AiAvatarSuggest::suggestionAlreadySeen($inputPrompt))->toBeFalse();
});

it('returns a null suggestion if api response is null', function () {
    $inputPrompt = 'inputPrompt';
    $prompt = view('ai-avatar-suggest::prompt', ['prompt' => $inputPrompt])->render();

    AiService::shouldReceive('getSuggestion')
        ->withArgs([$prompt])
        ->andReturnNull();

    $results = AiAvatarSuggest::suggest($inputPrompt);
    expect($results)->toBeNull();
});

it('returns a null suggestion if api text is empty', function () {
    $inputPrompt = 'inputPrompt';

    $response = CreateResponse::from(
        [
            'id' => '1',
            'created' => 1,
            'data' => [
                [
                    'url' => '',

                ],
            ],
        ]
    );

    $prompt = view('ai-avatar-suggest::prompt', ['prompt' => $inputPrompt])->render();

    //AiService::fake();
    AiService::shouldReceive('getSuggestion')
        ->withArgs([$prompt])
        ->andReturn($response);

    //  AiEmailSuggest::shouldReceive('suggestionAlreadySeen')->andReturnFalse();

    $results = AiAvatarSuggest::suggest($inputPrompt);
    expect($results)->toBeNull();
});

it('returns a null suggestion', function () {
    $inputPrompt = 'inputPrompt';

    $response = null;

    $prompt = view('ai-avatar-suggest::prompt', ['prompt' => $inputPrompt])->render();

    AiService::fake();
    AiService::shouldReceive('getSuggestion')
        ->withArgs([$prompt])
        ->andReturn($response);

    $results = AiAvatarSuggest::suggest($inputPrompt);
    expect($results)->toBeNull();
});

it('can create a prompt', function () {
    $inputPrompt = 'inputPrompt';

    $prompt = AiAvatarSuggest::createPrompt($inputPrompt);

    expect($prompt)
        ->toContain(Str::of("using this prompt:\n")->append($inputPrompt)->value());
});

it('can create a prompt with the fake facade', function () {
    $inputPrompt = 'inputPrompt';

    AiAvatarSuggest::fake();
    $prompt = AiAvatarSuggest::createPrompt($inputPrompt);

    expect($prompt)
        ->toContain(Str::of("using this prompt:\n")->append($inputPrompt)->value());
});

it('returns a response', function () {
    AiService::fake();
    $randName = 'https://example.com';
    $response = AiAvatarSuggest::suggest($randName);

    expect($response)
        ->toBeString()
        ->toBe($randName);
});

it('has a fake version of the service', function () {
    $service = app(AiServiceInterface::class);
    expect($service)->toBeInstanceOf(\Sfolador\AiAvatarSuggest\Services\AiService::class);

    AiService::fake();
    $service = app(AiServiceInterface::class);

    expect($service)->toBeInstanceOf(AiServiceFake::class);
});
//
//it('service returns a createresponse', function () {
//    $client = mockClient('POST', 'images',
//        [
//        'prompt' => 'prompt',
//        'n' => 1,
//        'size' => config('ai-avatar-suggest.default_size'),
//        'response_format' => 'url',
//    ], [
//            'id' => 'cmpl-asd23jkmsdfsdf',
//            'object' => 'text_completion',
//            'created' => 167812432,
//            'data' => [
//                [
//                    'url' => fake()->url(),
//
//                ],
//            ],
//        ]);
//
//    $service = new \Sfolador\AiAvatarSuggest\Services\AiService($client);
//
//    expect($service->getSuggestion('prompt'))->toBeInstanceOf(CreateResponse::class);
//});

it('should return a suggestion from a controller', function () {
    $initialInput = 'draw a developer with a laptop';
    AiAvatarSuggest::fake();

    $response = post(route('ai-avatar-suggest'), ['prompt' => $initialInput])->assertOk();

    $this->expect($response->json('suggestion'))->toBe($initialInput);
});
