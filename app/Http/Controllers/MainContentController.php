<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMainContentRequest;
use App\Http\Resources\MainContentResource;
use App\Libraries\ApiResponse;
use App\Models\MainContent;
use Arr;

class MainContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $content = MainContent::all()->sortBy('section');
        $content->each(function ($vis) {
            if (env('APP_ENV', 'local') !== 'local') {
                visits($vis)->increment();
            } else if (! env('NUMPANG', true)) {
                visits($vis)->forceIncrement(rand(3, 20));
            }
        });
        $res = [];
        foreach ($content as $key => $value) {
            $res = Arr::add($res, $value['section'], new MainContentResource($value));
        }
        return ApiResponse::success('', $res);
    }

    public function update(MainContent $content, UpdateMainContentRequest $request)
    {
        $req = $request->validated();
        $res = $content->whereId(request()->id)->update($req);
        return ApiResponse::created('Success Update MainContent', $res);
    }
}
