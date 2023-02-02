<?php

namespace App\Http\Controllers;

use App\Libraries\ApiResponse;
use App\Models\MainContent;

class MainContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $content = MainContent::all();
        $content->each(function ($vis) {
            if (env('APP_ENV', 'local') !== 'local') {
                visits($vis)->increment();
            } else {
                visits($vis)->forceIncrement(rand(3, 20));
            }
        });
        $res = $content
            ->makeHidden(['id', 'section', 'deleted_at', 'created_at', 'updated_at', 'user_id'])
            ->sortBy('section')->groupBy('section')
            ->map(fn($sec) => $sec->sortBy('updated_at')->first());
        return ApiResponse::success('', $res->toArray());
    }
}
