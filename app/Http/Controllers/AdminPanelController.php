<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormPaginateCollection;
use App\Http\Resources\PostPaginateCollection;
use App\Http\Resources\PostResource;
use App\Libraries\ApiResponse;
use App\Models\Form;
use App\Models\MailSubscription;
use App\Models\MainContent;
use App\Models\Post;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class AdminPanelController extends Controller
{
    public function dashboard()
    {
        // $post            = Post::latest();
        $last_update     = Post::with(['tags', 'author', 'category', 'media'])->whereNotNull('published_date')->orderByDesc('published_date')->first();
        $visit           = visits('\App\Models\Post');
        $most_visited    = $visit->top();
        $subscriber      = MailSubscription::all()->count();
        $subscriber_list = MailSubscription::all()->take(15);
        // dd(visits(Post::find('9856db85-e3f6-46d8-b004-871577957b59'))->count());
        $res = [
            'post_last'    => [
                'touch'  => Carbon::parse($last_update->published_date)->diff(now())->days ?? 0,
                'post'   => new PostResource($last_update) ?? [],
                'draft'  => Post::whereNull('published_date')->count() ?? 0,
                'oldest' => new PostResource(Post::with(['tags', 'author', 'category', 'media'])->whereNull('published_date')->orderBy('created_at', 'asc')->first()) ?? [],
            ],
            'visits'       => [
                'blog'    => $visit->count() ?? 0,
                'general' => $general_visits = visits(MainContent::first())->count() ?? 0,
                'total'   => $visit->count() + $general_visits ?? 0,
            ],
            'most_visited' => $most_visited ?? [],
            'subscriber'   => [
                'count' => $subscriber ?? [],
                'list'  => $subscriber_list ?? [],
            ],
        ];
        return ApiResponse::success('', $res);
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
                ->allowedFilters(['title', 'body', 'tags.title', 'tags.slug', 'author.name', 'author.slug', 'category.title', 'category.slug'])
                ->defaultSorts('-updated_at')
                ->allowedSorts(['published_date', 'updated_at', 'title', 'author.name', 'author.slug'])
                ->paginate($perPage)->appends(request()->query());
        return ApiResponse::success('', new PostPaginateCollection($res));
    }

    public function publish()
    {
        $unPublished = request()->filled('unPublished') ? request()->unPublished : null;
        $res         = Post::find(request()->postId)->update([
            'published_date' => $unPublished ? null : now(),
            'updated_at'     => now(),
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
