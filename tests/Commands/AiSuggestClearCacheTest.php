<?php

use Illuminate\Support\Facades\Cache;

it('does not do anything if cache does not support tags', function () {
    Cache::shouldReceive('supportsTags')->andReturn(false);

    $this->artisan('avatar-suggest:clear')
        ->expectsOutput('The cache driver does not support tags')
        ->assertExitCode(0);
});

it('clears cache id cache supports tags', function () {
    Cache::shouldReceive('supportsTags')->andReturn(true);

    Cache::shouldReceive('tags')->with('ai-avatar-suggest')->andReturnSelf();
    Cache::shouldReceive('flush');

    $this->artisan('avatar-suggest:clear')
        ->expectsQuestion('Are you sure you want to clear the cache of the avatar suggestions? (y/n)', 'y')
        ->expectsOutput('Clearing the cache of the avatar suggestions')
        ->expectsOutput('AiAvatarSuggest Cache cleared!')
        ->assertExitCode(0);
});

it('does not clear cache if user does not want to', function () {
    Cache::shouldReceive('supportsTags')->andReturn(true);

    $this->artisan('avatar-suggest:clear')
        ->expectsQuestion('Are you sure you want to clear the cache of the avatar suggestions? (y/n)', 'n')
        ->doesntExpectOutput('Clearing the cache of the avatar suggestions')
        ->doesntExpectOutput('AiAvatarSuggest Cache cleared!')
        ->assertExitCode(0);
});
