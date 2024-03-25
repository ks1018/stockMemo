<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);

        // 中カテゴリ登録
        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'is_managed' => true, // is_managedをデフォルトでtrueとして登録
        ]);

        return redirect()->route('categories.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSubCategories(Request $request) 
    {
        $category_id = $request->input('category_id');
        
        // カテゴリidに基づいて中カテゴリを取得
        $sub_categories = SubCategory::where('category_id', $category_id)->get();

        // JSON形式で中カテゴリを返す
        return response()->json($sub_categories);
    }
}
