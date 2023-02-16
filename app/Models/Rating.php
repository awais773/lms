<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    

    public function user() {
        return $this->hasMany(User::class, 'id', 'user_id');  
    }

    public function ratedUser()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function rater()
{
    return $this->belongsTo(User::class, 'rater_id');
}


}


