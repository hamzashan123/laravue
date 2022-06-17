<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\Proposals;
//use App\Models\Auth;
use Illuminate\Support\Facades\Auth;

class Comments extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'id',
        'from_user_id',
        'to_user_id',
        'listing_id',
        'message',        
        'status',
        'created_at',
        'updated_at'
    ];

    public function getUser() {
        return $this->hasOne(User::class,'id','from_user_id')
            ->select('users.*');
    }    

    public function getListing() {
        return $this->hasOne(Listing::class,'id','listing_id')
            ->select('listing.*');
    }
}
