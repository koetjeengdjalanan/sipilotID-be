<?php

namespace App\Http\Controllers;

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
        $content = MainContent::get();
        $content->each(function ($vis) {
            if (env('APP_ENV', 'local') !== 'local') {
                visits($vis)->increment();
            } else {
                visits($vis)->forceIncrement(rand(3, 20));
            }
        });
        $res = [];
        foreach ($content as $key => $value) {
            $res = Arr::add($res, $value['section'], new MainContentResource($value));
        }
        return ApiResponse::success('', $res);
    }
}
