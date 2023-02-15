<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\EventListResource;
use App\Http\Resources\FormPaginateCollection;
use App\Http\Resources\FormWithQuestionsResource;
use App\Libraries\ApiResponse;
use App\Models\Form;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $res = $query->orderByDesc('updated_at')->paginate($perPage);
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
        $nearest = isset($res) ? new EventListResource($res) : null;
        return isset($nearest) ? ApiResponse::success('', $nearest ?? []) : ApiResponse::notFound('No Upcoming Event', []);
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
        $res = Form::create([
            'user_id'      => $req['user_id'],
            'title'        => $req['title'],
            'slug'         => $req['slug'],
            'excerpt'      => $req['excerpt'],
            'description'  => $req['description'],
            'publish_date' => Carbon::createFromTimestamp($req['publish_date'])->toW3cString(),
            'expire'       => Carbon::createFromTimestamp($req['expire'])->toW3cString(),
        ])->saveOrFail();
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
    public function update(UpdateFormRequest $request, Form $form)
    {
        $req = $request->validated();
        $res = $form->whereId($req['id'])->first()->updateOrFail([
            'user_id'      => $req['user_id'],
            'title'        => $req['title'],
            'slug'         => $req['slug'],
            'excerpt'      => $req['excerpt'],
            'description'  => $req['description'],
            'publish_date' => Carbon::createFromTimestamp($req['publish_date'])->toW3cString(),
            'expire'       => Carbon::createFromTimestamp($req['expire'])->toW3cString(),
        ]);
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
    public function destroy(Request $request)
    {
        $res = Form::find($request->id);
        if (empty($res)) {
            return ApiResponse::unprocessableEntity('Param Required ID', ['tips' => 'perhaps your input is missed type']);
        }
        $res->deleteOrFail();
        return ApiResponse::success('Delete success', $res);
    }
}
