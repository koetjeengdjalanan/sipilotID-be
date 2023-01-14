<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMainContentRequest;
use App\Http\Requests\UpdateMainContentRequest;
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
        $res = MainContent::all();
        return ApiResponse::success('', ['available_section' => $res->pluck('section')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMainContentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMainContentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MainContent  $mainContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MainContent $mainContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MainContent  $mainContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(MainContent $mainContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMainContentRequest  $request
     * @param  \App\Models\MainContent  $mainContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMainContentRequest $request, MainContent $mainContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainContent  $mainContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MainContent $mainContent)
    {
        //
    }
}
