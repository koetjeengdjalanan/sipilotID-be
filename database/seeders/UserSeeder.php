<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name'     => 'The Watcher',
            'email'    => 'iam@watching.you',
            'password' => '$2y$10$XppvZCYhGaZ7jCN20GVAg.F5txQVzXwcY5hx2ryBENbgjSp36nzAa',
        ]);
        \App\Models\User::factory(10)->create();
    }
}
