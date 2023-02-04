<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\EventListResource;
use App\Http\Resources\FormPaginateCollection;
use App\Http\Resources\FormWithQuestionsResource;
use App\Libraries\ApiResponse;
use App\Models\Form;
use PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $res = Form::where('expire', '>=', now())->with('media')->get()->sortBy('expire')->take(6);
        return ApiResponse::success('', EventListResource::collection($res));
    }

    /**
     * Summary of adminIndex
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminIndex()
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

    /**
     * Show Upcoming Event
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcoming()
    {
        $res     = Form::where('publish_date', '>=', now())->with('media')->get()->sortBy('publish_date')->first();
        $nearest = new EventListResource($res);
        // dd($nearest);
        return ApiResponse::success('', $nearest ?? []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFormRequest $request)
    {
        $req = $request->validated();
        $res = Form::create($req)->saveOrFail();
        if (!$res) {
            return ApiResponse::error('Something Went Wrong', ['tips' => 'Check your input and/or validation']);
        }
        return ApiResponse::created('Form Created Successfully', $res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Form $form): \Illuminate\Http\JsonResponse
    {
        if (request()->isNotFilled('slug')) {
            return ApiResponse::unprocessableEntity('Query needed', ['tips' => 'Please provide slug in query!']);
        }
        $res = $form->whereSlug(request()->slug)->with(['questions', 'media'])->first();
        if (empty($res)) {
            return ApiResponse::notFound('Expire or None', ['tips' => 'Perhaps what you looking for is over or not existed']);
        }
        return ApiResponse::success('', new FormWithQuestionsResource($res));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormRequest  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFormRequest $request, Form $form, string $slug)
    {
        $req = $request->validated();
        $res = $form->whereSlug($slug)->update($req);
        if (!$res) {
            return ApiResponse::error('Something Went Wrong', ['tips' => 'Check your input and/or validation']);
        }
        return ApiResponse::created('Update Success', $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Form $form)
    {
        $res = $form->whereSlug(request()->slug);
        if (empty($res)) {
            return ApiResponse::unprocessableEntity('Param Required SLUG', ['tips' => 'perhaps your input is mistyped']);
        }
        $res->deleteOrFail();
        return ApiResponse::success('Delete success', []);
    }
}
