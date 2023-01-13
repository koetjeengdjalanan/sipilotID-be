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
        \App\Models\MainContent::factory(10)->create();
    }
}
