<?php

namespace App\Console\Commands;

use App\Models\Post;
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
        $visit = Post::latest()->paginate();
        dump($visit);
        return Command::SUCCESS;
    }
}
