<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family_group_id',
    ];

    // family_groupsとの連携
    public function familyGroup()
    {
        return $this->belongsTo(FamilyGroup::class);
    }

}
