<?php

namespace App\Console\Commands;

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
        $file = asset('storage/example.jpg');
        dd($file);
        return Command::SUCCESS;
    }
}
