<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\PostPaginateCollection;
use App\Http\Resources\TagResource;
use App\Libraries\ApiResponse;
use App\Models\Post;
use App\Models\Tag;
use Str;

class TagController extends Controller
{
    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $res = TagResource::collection(Tag::all());
        return ApiResponse::success('', $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request)
    {
        $tagArray = [];
        foreach ($request->validated()['tags'] as $key => $value) {
            $q = Tag::firstOrCreate([
                'slug' => Str::slug($value),
            ], [
                'title'   => $value,
                'user_id' => $request->validated()['user_id'],
            ]);
            array_push($tagArray, $q->id);
        };
        $res = Post::findOrFail($request->validated()['post_id'])->tags()->sync($tagArray);
        return ApiResponse::created('', $res);
    }

    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug)
    {
        $perPage = request()->filled('perPage') ? request()->perPage : null;
        $res     = Tag::where('slug', $slug)->first()->posts()->with(['author', 'category', 'tags', 'media'])->paginate($perPage);
        return ApiResponse::success('', new PostPaginateCollection($res));
    }
}
