<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FamilyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($familyGroup) {
    //         $familyGroup->createCategories();
    //     });
    // }

    // public function createCategories()
    // {
    //     // カテゴリを生成する処理を行う
    //     $categories = ['食品', '日用品', '常備薬'];

    //     foreach ($categories as $categoryName) {
    //         $category = Category::create(['name' => $categoryName]);
    //         $category->update(['family_group_id' => $this->id]);
    //     }
    // }

    // userとのリレーション
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}
