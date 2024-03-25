<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'is_managed',
    ];

    // categoryとの連携
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
