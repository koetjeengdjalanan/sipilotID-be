<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Carbon;

class AdminPanelController extends Controller
{
    public function dashboard()
    {
        $post        = Post::latest();
        $last_update = Carbon::parse($post->whereNotNull('published_date')->orderByDesc('published_date')->first()->published_date)->diff(now())->days;
        $data        = [
            'title'       => 'Dashboard',
            'post_count'  => $post->count(),
            'active'      => 'dashboard',
            'last_update' => $last_update,
        ];
        // dd($data['last_update']);
        return view('dashboard.main', $data);
    }
}
