<?php

namespace App\Console\Commands;

use App\Models\Category;
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
        $delete = Category::find('9872c3a5-c758-4adf-8249-04e00bd2eae4')->delete();
        dd($delete);
        return Command::SUCCESS;
    }
}
