<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'title',
        'message',        
        'seen',  
        'status',
        'created_at',
        'updated_at'
    ];

    public function getUser() {
        return $this->hasOne(User::class,'id','user_id')
            ->select('users.*');
    }
}
