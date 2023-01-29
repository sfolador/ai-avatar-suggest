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
    'default_size' => '256x256'
];
```

*Remember to set your OpenAI key in your .env file.*

## Usage

```php
$aiAvatarSuggest = new Sfolador\AiAvatarSuggest();
echo $aiAvatarSuggest->suggest('A developer with a red beard and a cool hat');
```
You can also invoke the generation by calling the route `ai-avatar-suggest` with a `prompt` parameter.
The response will be a JSON with the suggested email, such as:

```json
{
  "suggestion": "https://www.example.com/link/to/avatar"
}
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
