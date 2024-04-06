<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
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
        // $items = Item::all();

        // 出庫日がnullの商品一覧取得
        $user = auth()->user();
        // dd($user);
        $family_group_id = $user->family_group_id;
        // dd($family_group_id);
        $categories = Category::where('family_group_id',$family_group_id)->get();
        // dd($categories);
        $category_ids = $categories->pluck('id')->toArray();
        // dd($category_ids);
        $subCategories = SubCategory::whereIn('category_id',$category_ids)->get();
        // dd($subCategories);
        $subcategory_ids = $subCategories->pluck('id')->toArray();
        // dd($subcategory_ids);
        
        $items = Item::whereHas('SubCategory', function($query) use ($subcategory_ids) {
            $query->whereIn('sub_category_id', $subcategory_ids)->whereNull('out_date');
        })->with(['subCategory.category:id,name', 'shop'])->orderBy('sub_category_id')->paginate(10);
        // dd($items);
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
                'price' => 'required|numeric|min:0|max:100000',
                'shop_name' => 'required|max:100',
                'sub_category_id' => 'required',
            ]);

            // group_idを取得
            $family_group_id = Auth::user()->family_group_id;
            // dd($family_group_id);

            // 購入店を取得または作成
            $shop = Shop::firstOrCreate([
                'name' => $request->shop_name,
                'family_group_id' => $family_group_id
            ]);
            // dd($request->shop_name);


            // 作成した店舗情報からidを取得
            $shop_id = $shop->id;
            // dd($shop_id);

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

    // 商品編集画面を表示 ToDo　itemのadd.blade.phpをコピーして、編集画面を作成する
    public function edit($id) 
    {
        $item = Item::find($id);
        $sub_category = SubCategory::find($item->sub_category_id);
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id',$sub_category->category_id)->get();
        $shop = Shop::find($item->shop_id);

        return view('item.itemEdit', compact('item', 'sub_category', 'categories', 'subCategories', 'shop'));
    }

    // 商品情報を更新する
    public function update(Request $request, Item $item)
    {
        // dd($item);
        $this->validate($request, [
            'item_name' => 'required|max:100',
            'price' => 'required|numeric|min:0|max:100000',
            'shop_name' => 'required|max:100',
            'sub_category_id' => 'required',
        ]);

            // group_idを取得
            $family_group_id = Auth::user()->family_group_id;
            // dd($family_group_id);

            // 購入店を取得または作成
            $shop = Shop::firstOrCreate([
                'name' => $request->shop_name,
                'family_group_id' => $family_group_id
            ]);
            // dd($request->shop_name);

            // 作成した店舗情報からidを取得
            $shop_id = $shop->id;
            // dd($shop_id);

        $item->update([
            'name' => $request->item_name,
            'price' => $request->price,
            'best_before_date' => $request->best_before_date,
            'memo' => $request->memo,
            'shop_id' => $shop_id,
            'sub_category_id' => $request->sub_category_id,
        ]);

        return redirect('/items');
    }

    // 出庫処理
    public function handleStockOut($id)
    {
        $item = Item::find($id);

        // 出庫日を今日の日付に設定
        $item->out_date = date('Y_m_d');
        $item->save();

        return redirect()->back();
    }

    // 削除処理
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()->route('items.index');
    }

}
