<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "This is the index method of CategoryController";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return "This is the create method of CategoryController";
        $categories = Category::where('family_group_id', Auth::user()->family_group_id)->get();
        $subcategories = SubCategory::whereHas('category', function ($query) use ($categories) {
            $query->whereIn('id', $categories->pluck('id'));
        })->orderBy('category_id')->get();

        $subcategoriesByCategory = $subcategories->groupBy('category_id');

        return view('category.createCategory',compact('categories', 'subcategoriesByCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|max:100',
        ]);

        // ログインユーザーのfamily_group_idを取得
        $family_group_id = auth()->user()->family_group_id;

        // 同じカテゴリがすでに存在するかチェック
        $existingCategory = Category::where('name', $request->category_name)
                                    ->where('family_group_id', $family_group_id)
                                    ->first();

        // もし同じカテゴリがすでに存在すればリダイレクト
        if ($existingCategory) {
            return redirect()->route('categories.create')->with('messege', '同じカテゴリが既に存在します。');
        }
        // 存在しない場合はカテゴリ登録
        Category::create([
            'name' => $request->category_name,
            'family_group_id' => $family_group_id
        ]);

        return redirect()->route('categories.create')->with('messsage', 'カテゴリが登録されました。');
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
}
