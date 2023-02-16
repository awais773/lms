<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cource extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    // protected $fillable = [

    //     'name',
    //     'user_id',
    //     'details',
    // ] ;


    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');  
    }


}


