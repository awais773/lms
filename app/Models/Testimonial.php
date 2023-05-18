<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    public function teacher() {
        return $this->hasOne(User::class, 'id', 'teacher_id');  
    }

}
