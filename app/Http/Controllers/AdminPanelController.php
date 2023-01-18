<?php

namespace App\Http\Controllers;

use App\Models\MailSubscription;
use App\Models\Post;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class AdminPanelController extends Controller
{
    public function dashboard()
    {
        $post        = Post::latest();
        $last_update = Carbon::parse($post->whereNotNull('published_date')->orderByDesc('published_date')->first()->published_date)->diff(now())->days;
        $visit       = visits('App\Models\Post')->count();
        $subscriber  = MailSubscription::all()->count();
        $data        = [
            'title'       => 'Dashboard',
            'active'      => 'dashboard',
            'post_count'  => $post->count(),
            'last_update' => $last_update,
            'visitor'     => $visit,
            'subscriber'  => $subscriber,
            'posts'       => $post->paginate(),
            'chosen'      => '',
        ];
        // dd($post->paginate()->lastPage());
        return view('dashboard.main', $data);
    }

    public function destroy()
    {
        $post = Post::find(request()->id)->delete();
        // dd($post);
        return redirect()->back();
    }

    public function subscriber()
    {
        $subs = MailSubscription::latest();
        $data = [
            'title'  => 'Mail Subscriber',
            'active' => 'mail.subscriber',
            'subs'   => $subs->paginate(),
        ];
        return view('mail.subscriber', $data);
    }

    public function compose()
    {
        $subs = MailSubscription::latest();
        $data = [
            'title'  => 'Mail compose',
            'active' => 'mail.compose',
            // 'subs'   => $subs->paginate(),
        ];
        return view('mail.compose', $data);
    }
}
