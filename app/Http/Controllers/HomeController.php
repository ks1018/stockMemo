<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FamilyGroup;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Item;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    // SubCategoryモデルに記述の関数を使って、userのデータ取得する
    public function getUserItems()
    {
        $subcategory = new SubCategory;
        $userItems = $subcategory->getUserDataWithRelatedTables(auth()->id());
        // dd($userItems);

        // 取得したデータをビューに渡すなど、必要な処理を行う
        return view('home', ['userItems' => $userItems]);
    }

}
