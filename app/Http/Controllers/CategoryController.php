<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoriesPaginateCollection;
use App\Libraries\ApiResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $res = Category::all()->sortByDesc('updated_at')->paginate();
        return ApiResponse::success('', new CategoriesPaginateCollection($res));
    }

    /**
     * Display a detailed listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function list() {
        $res = Category::with('author')->paginate();
        return ApiResponse::success('', $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $req = $request->validated();
        $res = Category::create($req);
        return ApiResponse::created('', $res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category, string $slug)
    {
        $res = $category->with('author')->whereSlug($slug)->first();
        return ApiResponse::success('', $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $req = request()->validate([
            'id' => 'required|uuid|exists:\App\Models\Category,id',
        ]);
        $res = $category->whereId($req['id'])->delete();
        return ApiResponse::success('deleted', $res);
    }
}
