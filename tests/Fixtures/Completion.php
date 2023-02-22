<?php

/**
 * @see https://github.com/openai-php/client
 *
 * @return array<string, mixed>
 */
function completion(): array
{
    return [
        'id' => 'cmpl-asd23jkmsdfsdf',
        'object' => 'text_completion',
        'created' => 167812432,
        'data' => [
            [
                'url' => fake()->url(),

            ],
        ],
    ];
}
