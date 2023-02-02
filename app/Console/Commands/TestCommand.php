<?php

namespace App\Console\Commands;

use Http;
use Illuminate\Console\Command;

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
        dd(str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/ul/ol/dl/bq/decorate')->body()));
        return Command::SUCCESS;
    }
}
