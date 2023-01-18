<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostPaginateCollection;
use App\Http\Resources\PostResource;
use App\Libraries\ApiResponse;
use App\Models\Post;

class PostController extends Controller
{
    protected $post;
    public function __construct()
    {
        $this->post = Post::with(['tags', 'author', 'category', 'media'])->orderByDesc('published_date');
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
        // $res     = new PostCollection($this->post->paginate($perPage));
        $res = new PostPaginateCollection($this->post->paginate($perPage));
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
        $query->visitCounter()->increment();
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
        // dd($this->post->first());
        $res = $this->post->get()->random();
        $res->visitCounter()->increment();
        return ApiResponse::success('', new PostResource($res));
    }
}
