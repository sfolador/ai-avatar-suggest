# Create avatar for your users with openai

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfolador/ai-avatar-suggest.svg?style=flat-square)](https://packagist.org/packages/sfolador/ai-avatar-suggest)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/ai-avatar-suggest/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sfolador/ai-avatar-suggest/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/ai-avatar-suggest/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sfolador/ai-avatar-suggest/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sfolador/ai-avatar-suggest.svg?style=flat-square)](https://packagist.org/packages/sfolador/ai-avatar-suggest)

Use this library to generate avatars for your users by letting them insert a
short description about themselves.

## Installation

You can install the package via composer:

```bash
composer require sfolador/ai-avatar-suggest
```


You can publish the config file with:

```bash
php artisan vendor:publish --tag="ai-avatar-suggest-config"
```

This is the contents of the published config file:

```php
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
```

*Remember to set your OpenAI key in your .env file.*

If the `use_cache` option is set to `true`, the package will use the default cache driver to prevent
unnecessary calls to the OpenAI API. You can change the cache driver in your `config/cache.php` file.

## Usage

```php
$aiAvatarSuggest = new Sfolador\AiAvatarSuggest();
echo $aiAvatarSuggest->suggest('A developer with a red beard and a cool hat');

//or if you want to use the facade

echo AiAvatarSuggest::suggest('A developer with a red beard and a cool hat');

```
You can also invoke the generation by calling the route `ai-avatar-suggest` with a `prompt` parameter.
The response will be a JSON with the suggested email, such as:

```json
{
  "suggestion": "https://www.example.com/link/to/avatar"
}
```


## Cache clear

If you use a Cache driver that supports tags, you can clear the cache by invoking the command:

```bash
php artisan ai-avatar-suggest:clear-cache
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [sfolador](https://github.com/sfolador)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
