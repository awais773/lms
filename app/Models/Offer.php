<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    
    protected $guarded = [] ;

    public function teacher() {
        return $this->hasOne(User::class, 'id', 'teacher_id');  
    }

    public function student() {
        return $this->hasOne(User::class, 'id', 'student_id');  
    }


    public function cource() {
        return $this->hasOne(User::class, 'id', 'cource_id');  
    }


    public function courses()
    {
        return $this->belongsTo(Cource::class, 'cource_id');
    }



}