<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;


class FamilyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
