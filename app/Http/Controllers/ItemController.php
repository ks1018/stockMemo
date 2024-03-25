<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Shop;


class ItemController extends Controller
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
     * 商品一覧
     */
    public function index()
    {
// 商品一覧取得
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'item_name' => 'required|max:100',
                'shop_name' => 'required|max:100',
            ]);

            // group_idを取得
            $group_id = Auth::user()->group_id;
            dd($group_id);

            // 購入店を取得または作成
            $shop = Shop::firstOrCreate([
                'name' => $request->shop_name,
                'group_id' => $group_id
            ]);

            // 作成した店舗情報からidを取得
            $shop_id = $shop->id;

            // 商品登録
            Item::create([
                // 'user_id' => Auth::user()->id,
                'name' => $request->item_name,
                'price' => $request->price,
                'best_before_date' => $request->best_before_date,
                'memo' => $request->memo,
                'shop_id' => $shop_id,
                'sub_category_id' => $request->sub_category_id,
            ]);

            return redirect('/items');
        }

        $categories = Category::all();
        $subCategories = SubCategory::all();

        return view('item.add', compact('categories', 'subCategories'));
    }
}
