<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Libraries\ApiResponse;
use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $res = Media::orderBy('created_at', 'desc')->paginate();
        return ApiResponse::success('', $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Media $media)
    {
        if (request()->isNotFilled('id')) {
            return ApiResponse::unprocessableEntity('Id Params Required', ['tips' => 'check your query and try again']);
        }
        $res = $media->whereId(request()->id)->first();
        return ApiResponse::success('', new MediaResource($res));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Media $media)
    {
        if (request()->isNotFilled('id')) {
            return ApiResponse::unprocessableEntity('Id Params Required', ['tips' => 'check your query and try again']);
        }
        $res = $media->whereId(request()->id)->delete();
        return ApiResponse::success('', $res);
    }
}
