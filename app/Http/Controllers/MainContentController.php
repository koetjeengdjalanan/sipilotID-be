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
        $res = MainContent::all()
            ->makeHidden(['id', 'section', 'deleted_at', 'created_at', 'updated_at', 'user_id'])
            ->sortBy('section')->groupBy('section')
            ->map(fn($sec) => $sec->sortBy('updated_at')->first());
        return ApiResponse::success('', $res);
    }
}
