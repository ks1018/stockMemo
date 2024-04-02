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
            'category_id' => 'required',
        ]);

        // ログインユーザーのfamily_group_idを取得
        $family_group_id = auth()->user()->family_group_id;

        // 同じカテゴリー内で同じサブカテゴリーが存在するかチェック
        $existingSubcategory = Subcategory::where('name', $request->name)
                                        ->where('category_id', $request->category_id)
                                        ->whereHas('category', function($query) use ($family_group_id) {
                                            $query->where('family_group_id', $family_group_id);
                                        })
                                        ->first();

        // もし同じサブカテゴリーがすでに存在すればリダイレクト
        if ($existingSubcategory) {
            return redirect()->route('categories.create')->with('messege', '同じ中カテゴリーが既に存在します。');
        }
        // 存在しない場合は中カテゴリ登録
        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'is_managed' => true, // is_managedをデフォルトでtrueとして登録
        ]);

        return redirect()->route('categories.create')->with('messege', '中カテゴリーが登録されました。');
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
