<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Messages extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'id',
        'from_user_id',
        'to_user_id',
        'message',
        'seen',
        'is_email_sent',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getFromUser() {
        return $this->hasOne(User::class,'id','from_user_id')
            ->select('users.*');
    }

    public function getToUser() {
        return $this->hasOne(User::class,'id','to_user_id')
            ->select('users.*');
    }
}
