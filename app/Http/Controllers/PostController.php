<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostPaginateCollection;
use App\Http\Resources\PostResource;
use App\Libraries\ApiResponse;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\Search;

class PostController extends Controller
{
    protected $post;
    public function __construct()
    {
        // $this->post = Post::with(['tags', 'author', 'category', 'media'])->where('published_date', '<=', now())->orderByDesc('published_date');
        $this->post = QueryBuilder::for(Post::class)
                ->with(['tags', 'author', 'category', 'media'])
                ->allowedFilters(['title', 'body', 'tags.title', 'tags.slug', 'author.name', 'author.slug', 'category.title', 'category.slug'])
                ->defaultSorts('-updated_at')
                ->allowedSorts(['published_date', 'updated_at', 'title', 'author.name', 'author.slug']);
    }

    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Return Paginated Post for Posts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $perPage = request()->filled('perPage') ? request()->perPage : null;
        $res     = new PostPaginateCollection($this->post->paginate($perPage)->appends(request()->query()));
        return ApiResponse::success('', $res);
    }

    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Show one Posts, Based on slug
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug)
    {
        $query = $this->post->where('slug', $slug)->first();
        if(env('APP_ENV', 'local') !== 'local'){
            visits($query)->increment();
        } else {
            visits($query)->forceIncrement(rand(3, 20));
        }
        $res = new PostResource($query);
        return ApiResponse::success('', $res);
    }

    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Return Random Post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function random()
    {
        $res = $this->post->get()->random();
        if ($res) {
            if(env('APP_ENV', 'local') !== 'local'){
                visits($res)->increment();
            } else {                
                visits($res)->forceIncrement(rand(3,20));
            }
            return ApiResponse::success('', new PostResource($res));
        }
        return ApiResponse::notFound('', ['tips' => "Generate One on Admin Panel"]);
    }

    public function search()
    {
        if (request()->missing('keyword')) {
            return ApiResponse::forbidden('Missing Params', ['required_param' => 'keyword']);
        }
        $res = (new Search())->registerModel(Post::class, 'title', 'slug', 'body')->search(request()->keyword)->pluck('searchable')->take(5);
        // dd($res);
        return ApiResponse::success('', $res);
    }
}
