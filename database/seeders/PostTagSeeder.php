<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all()->pluck('id');
        $tags  = Tag::all()->pluck('id');
        foreach ($posts as $key => $value) {
            $repertoire = rand(floor($tags->count() / rand(3, 4)), $tags->count());
            for ($i = 0; $i < $repertoire; $i++) {
                DB::table('post_tag')->insertOrIgnore([
                    'post_id' => $value,
                    'tag_id'  => $tags->random(),
                ]);
            }
        }
    }
}
