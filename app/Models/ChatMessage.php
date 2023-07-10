<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'user_id',
        'sender_id',
        'created_at',
        'offer',
        'type',

    ];

    protected $attributes = [
        'seen' => 0,
    ];

}
