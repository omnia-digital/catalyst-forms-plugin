<?php

namespace OmniaDigital\CatalystForms\Commands;

use Illuminate\Console\Command;

class CatalystFormsPluginCommand extends Command
{
    public $signature = 'catalyst-forms-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
