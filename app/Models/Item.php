<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'best_before_date',
        'out_date',
        'memo',
        'shop_id',
        'sub_category_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    // subcategryとのリレーション
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

        // shopとのリレーション
        public function shop()
        {
            return $this->belongsTo(Shop::class,'shop_id', 'id');
        }
    
}
