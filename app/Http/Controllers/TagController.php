<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\TagResource;
use App\Libraries\ApiResponse;
use App\Models\Post;
use App\Models\Tag;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        //
    }

    /**
     * !This Shit Is Broken
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return PostCollection
     */
    public function show(string $slug)
    {
        $perPage = request()->filled('perPage') ? request()->perPage : null;
        // $tag     = Tag::where('slug', $slug)->first();
        $res = Post::with(['tags', 'author', 'category'])->orWhereHas('tags', function ($q) use ($slug) {
            $q->where('tags', $slug);
        })->get();
        dump($res);
        return new PostCollection($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
