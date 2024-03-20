<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\FamilyGroup;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Userモデルを作成時に同時にFamilyGroupを作成、設定
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            $familyGroup = FamilyGroup::create();
            $user->family_group_id = $familyGroup->id; 
        });
    }
    
    // family_groupsとの連携
    public function familyGroup()
    {
        return $this->belongsTo(FamilyGroup::class);
    }
    
}
