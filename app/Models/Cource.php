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


    public function teacher() {
        return $this->hasOne(User::class, 'id', 'user_id');  
    }


    public function Class() {
        return $this->hasOne(Category::class, 'id', 'class_id');  
    }

    public function subject() {
        return $this->hasOne(Subject::class, 'id', 'subject_id');  
    }


}


