<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\FamilyGroup;
use App\Models\Shop;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'is_managed',
    ];

    function getUserDataWithRelatedTables($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return null;
        }

        $familyGroupId = $user->family_group_id;

        return DB::table('users')
            ->join('family_groups', 'users.family_group_id', '=', 'family_groups.id')
            ->join('categories', 'family_groups.id', '=', 'categories.family_group_id')
            ->join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('items', 'sub_categories.id', '=', 'items.sub_category_id')
            ->join('shops', 'items.shop_id', '=', 'shops.id')
            ->select('users.*', 'family_groups.*', 'categories.*', 'sub_categories.*', 'items.*', 'shops.*')
            ->where('users.id', $userId)
            ->get();
    }

    // これを使って上のデータ取得する関数を呼び出す　下記は利用するコントローラー内の記述例
    // public function getUserData()
    // {
    //     $userData = getUserDataWithRelatedTables(auth()->id());

    //     // 取得したデータをビューに渡すなど、必要な処理を行う
    //     return view('user.profile', ['userData' => $userData]);
    // }

    // categoryとの連携
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
