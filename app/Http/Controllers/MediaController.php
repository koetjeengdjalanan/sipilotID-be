<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAssetRequest;
use App\Http\Requests\MediaUploadRequest;
use App\Http\Requests\StorePostMediaRequest;
use App\Http\Resources\MediaResource;
use App\Libraries\ApiResponse;
use App\Models\Asset;
use App\Models\Form;
use App\Models\Media;
use App\Models\Post;
use File;
use Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $res = Asset::orderByDesc('created_at')->paginate();
        return ApiResponse::success('', $res);
    }

    /**
     * Attach a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostMediaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePost(StorePostMediaRequest $request, Post $post)
    {
        $media = new Media(['path' => $request->validated()['path']]);
        $res   = $post->whereId($request->validated()['post_id'])->first()->media()->save($media);
        return ApiResponse::created('success attach media', $res);
    }

    /**
     * Attach a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostMediaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeForm(StorePostMediaRequest $request, Form $form)
    {
        $media = new Media(['path' => $request->validated()['path']]);
        $res   = $form->whereId($request->validated()['form_id'])->first()->media()->save($media);
        return ApiResponse::created('success attach media', $res);
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
        $res = $media->whereId(request()->id)->firstOrFail();
        return ApiResponse::success('', new MediaResource($res));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteAssetRequest $deleteAssetRequest, Media $media)
    {
        $assetPath = Asset::find($deleteAssetRequest->validated()['id']);
        $fileName  = Str::after($assetPath->toArray()['url'], env('APP_URL', 'https://localhost') . '/media/');
        if (File::exists(public_path('media/' . $fileName))) {
            File::delete(public_path('media/' . $fileName));
            $res = $assetPath->delete();
        }
        return ApiResponse::success('', $res);
    }

    public function upload(MediaUploadRequest $mediaUploadRequest)
    {
        $fileName = Str::lower(Str::ulid()) . "." . $mediaUploadRequest->file->extension();
        Asset::create([
            'url' => env('APP_URL', 'https://localhost') . '/media/' . $fileName,
        ]);
        $mediaUploadRequest->file->move(public_path('media'), $fileName);
        return ApiResponse::created('File Uploaded', env('APP_URL', 'http://localhost') . "/media/" . $fileName);
    }
}
