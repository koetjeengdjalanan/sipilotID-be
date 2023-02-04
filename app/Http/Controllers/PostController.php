<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostPaginateCollection;
use App\Http\Resources\PostResource;
use App\Libraries\ApiResponse;
use App\Models\Post;
use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PostController extends Controller
{
    protected $post;
    public function __construct()
    {
        $this->post = QueryBuilder::for(Post::class)
                ->with(['tags', 'author', 'category', 'media'])
                ->allowedFilters([
                    'title', 'body', 'tags.title', 'tags.slug', 'author.name', 'author.slug', 'category.title', 'category.slug',
                ])
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
    public function show(Post $post, string $slug)
    {
        $query = $post->whereSlug($slug)->with(['tags', 'author', 'category', 'media'])->first();
        if (empty($query)) {
            return ApiResponse::notFound('post not found!', ['tips' => 'Find details here ' . route('post.index')]);
        }
        if (env('APP_ENV', 'local') !== 'local') {
            visits($query)->increment();
        } else if (!env('NUMPANG', true)) {
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
            if (env('APP_ENV', 'local') !== 'local') {
                visits($res)->increment();
            } else if (!env('NUMPANG', true)) {
                visits($res)->forceIncrement(rand(3, 20));
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
        $res = (new Search())->registerModel(Post::class, function (ModelSearchAspect $modelSearchAspect) {
            $modelSearchAspect->with(['tags', 'author', 'category', 'media'])
                ->addSearchableAttribute('title')
                ->addSearchableAttribute('slug')
                ->addSearchableAttribute('body');
        })->search(request()->keyword)->pluck('searchable')->take(5);
        // dd($res);
        return ApiResponse::success('', PostResource::collection($res));
    }

    public function store(Post $post, StorePostRequest $storePostRequest)
    {
        $res = $post->create($storePostRequest->validated());
        return ApiResponse::created('Post Created Successfully', $res);
    }

    public function update(Post $post, UpdatePostRequest $updatePostRequest)
    {
        if (empty(request()->id)) {
            return ApiResponse::unprocessableEntity('Missing Param', ['param' => 'id']);
        }
        $res = $post->whereId(request()->id)->update($updatePostRequest->validated());
        return ApiResponse::success('Post Updated Successfully', new PostResource($res));
    }

    public function publish()
    {
        // dd(Carbon::createFromTimestamp(request()->published_date)->toW3cString());
        if (empty(request()->id)) {
            return ApiResponse::unprocessableEntity('Missing Param', ['param' => route('admin.post.publish') . '/{id}']);
        }
        if (empty(request()->published_date)) {
            return ApiResponse::unprocessableEntity('Missing Param', ['param' => 'published_date']);
        }
        $res = Post::whereId(request()->id)->update(['published_date' => Carbon::createFromTimestamp(request()->published_date)->toW3cString()]);
        return ApiResponse::success('Post Published', ['id' => request()->id]);
    }
}
