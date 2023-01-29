<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormPaginateCollection;
use App\Http\Resources\PostPaginateCollection;
use App\Libraries\ApiResponse;
use App\Models\Form;
use App\Models\MailSubscription;
use App\Models\Post;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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

    public function eventForm()
    {
        $perPage              = request()->filled('perPage') ? request()->perPage : null;
        $query                = Form::with(['author', 'media']);
        (bool) $publishFilter = request()->published_only;
        if ($publishFilter === 'true') {
            $query = $query->whereNotNull('published_date');
        }
        $res = $query->orderBy('updated_at')->paginate($perPage);
        return ApiResponse::success('', new FormPaginateCollection($res));
    }

    // public function postList()
    // {
    //     $perPage              = request()->filled('perPage') ? request()->perPage : null;
    //     $query                = Post::with(['tags', 'author', 'category', 'media']);
    //     (bool) $publishFilter = request()->published_only;
    //     if ($publishFilter === 'true') {
    //         $query = $query->whereNotNull('published_date');
    //     }
    //     $res = $query->orderByDesc('created_at');
    //     return ApiResponse::success('', new PostPaginateCollection($res->paginate($perPage)));
    // }

    public function postList()
    {
        $perPage = request()->filled('perPage') ? request()->perPage : null;
        $res     = QueryBuilder::for(Post::class)
            ->with(['tags', 'author', 'category', 'media'])
            ->allowedFilters(['title', 'body', 'tags.title',  'tags.slug', 'author.name', 'author.slug', 'category.title', 'category.slug'])
            ->defaultSorts('-updated_at')
            ->allowedSorts(['published_date', 'updated_at', 'title', 'author.name', 'author.slug'])
            ->paginate($perPage)->appends(request()->query());
        return ApiResponse::success('', new PostPaginateCollection($res));
    }

    public function publish()
    {
        $unPublished = request()->filled('unPublished') ? request()->unPublished : null;
        $res = Post::find(request()->postId)->update([
            'published_date' => $unPublished ? null :now(),
            'updated_at' => now(),
        ]);
        // $res = Post::find(request()->postId);
        // var_dump($res, request()->postId);
        return ApiResponse::success('', ['message' => $res]);
    }

    public function form()
    {
        $res = Form::with(['media', 'author'])->paginate();
        return ApiResponse::success('', $res);
    }
}
