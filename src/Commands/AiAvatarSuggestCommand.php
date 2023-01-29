<?php

namespace Sfolador\AiAvatarSuggest\Commands;

use Illuminate\Console\Command;

class AiAvatarSuggestCommand extends Command
{
    public $signature = 'ai-avatar-suggest';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
