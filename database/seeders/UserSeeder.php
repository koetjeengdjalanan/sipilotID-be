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
            'username' => 'thewatcher',
            'email'    => 'iam@watching.you',
            'password' => '$2y$10$XppvZCYhGaZ7jCN20GVAg.F5txQVzXwcY5hx2ryBENbgjSp36nzAa',
        ])->media()->create([
            'path' => 'https://loremflickr.com/640/480',
        ]);
        $users = \App\Models\User::factory(10)->create();
        foreach ($users as $key => $user) {
            $user->media()->create([
                'path' => 'https://loremflickr.com/640/480',
            ]);
        }
    }
}
