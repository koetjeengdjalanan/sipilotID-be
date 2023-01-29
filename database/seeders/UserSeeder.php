<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $roles    = Role::all();
        $rootUser = \App\Models\User::factory()->create([
            'name'     => 'The Watcher',
            'username' => 'thewatcher',
            'email'    => 'iam@watching.you',
            'password' => bcrypt('testing123'),
        ]);
        $rootUser->media()->create([
            'path' => 'https://source.unsplash.com/random/?selfie',
        ]);
        $rootUser->assignRole($roles[0]);
        $users = \App\Models\User::factory(10)->create();
        foreach ($users as $key => $user) {
            $user->media()->create([
                'path' => 'https://source.unsplash.com/random/?selfie',
            ]);
            $user->assignRole($roles->random());
        }
    }
}
