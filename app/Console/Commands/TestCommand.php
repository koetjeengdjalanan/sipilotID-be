<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ignore This!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $availableType = [
            'text',
            'listbox',
            'datetime',
        ];
        $type = Arr::random($availableType);
        dump($type, gettype($type));
        return Command::SUCCESS;
    }
}
