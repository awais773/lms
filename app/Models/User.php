<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $primaryKey = 'id'; 
    // public $incrementing = false; // Disable auto-incrementing

    // protected $keyType = 'string';
     protected $guarded = [] ;

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'role_id',
    //     'mobile_number',
    //     'country',
    //     'location',
    //     'type',
    //     'information',
    //     'image',
    //     'nationality',
    //     'age',
    //     'skills',

    // ];

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
    ];

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');  
    }

    public function qualification() {
        return $this->hasOne(qualification::class, 'id', 'qualification_id');  
    }

    public function ratings()
{
    return $this->hasMany(Rating::class);
}


public function unseenMessages()
{
    return $this->hasMany(ChatMessage::class, 'user_id', 'id')
        ->where('seen', false);
}

}
