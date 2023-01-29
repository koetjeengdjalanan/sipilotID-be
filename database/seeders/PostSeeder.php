<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::factory(250)->create();
        foreach ($posts as $key => $post) {
            $post->media()->create([
                'path' => 'https://source.unsplash.com/random/480%C3%97640?lansdcape',
            ]);
        }
        Post::all()->random(rand(23, 75))->each(function ($item, $key) {
            $item->delete();
        });
    }
}
