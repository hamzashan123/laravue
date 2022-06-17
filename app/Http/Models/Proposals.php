<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;

class Proposals extends Model
{
    protected $table = 'proposals';

    protected $fillable = [
        'id',
        'listing_id',
        'user_id',
        'min_budget',
        'max_budget',
        'target_startdate',
        'target_enddate',
        'approved_by',
        'rejected_by',
        'status',
        'created_at',
        'updated_at'
    ];

    
    /*public function getClinet() {
        return $this->hasOne(User::class,'id','client_id')
            ->select('users.*');
    }*/

    public function getContractor() {
        return $this->hasOne(User::class,'id','user_id')
            ->select('users.*');
    }

    public function getApprovedBy() {
        return $this->hasOne(User::class,'id','approved_by')
            ->select('users.*');
    }

    public function getRejectBy() {
        return $this->hasOne(User::class,'id','rejected_by')
            ->select('users.*');
    }    

    public function getListing() {
        return $this->hasOne(Listing::class,'id','listing_id')
            ->select('listing.*');
    }

}
