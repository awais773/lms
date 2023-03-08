<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    // protected $fillable = [

    //     'name',
    //     'user_id',
    //     'details',
    // ] ;


    public function student() {
        return $this->hasOne(User::class, 'id', 'student_id');  
    }

    public function teacher() {
        return $this->hasOne(User::class, 'id', 'teacher_id');  
    }


}


