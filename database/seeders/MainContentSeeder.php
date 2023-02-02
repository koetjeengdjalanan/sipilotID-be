<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MainContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = \App\Models\MainContent::factory(10)->create();
        $contents->each(function ($content) {
            visits($content)->forceIncrement(50);
        });
    }
}
