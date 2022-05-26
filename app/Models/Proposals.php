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
        'client_id',
        'listing_id',
        'contractor_id',
        'min_budget',
        'max_budget',
        'target_startdate',
        'target_enddate',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getClinet() {
        return $this->hasOne(User::class,'id','client_id')
            ->select('users.*');
    }

    public function getContractor() {
        return $this->hasOne(User::class,'id','contractor_id')
            ->select('users.*');
    }

    public function getListing() {
        return $this->hasOne(Listing::class,'id','listing_id')
            ->select('listing.*');
    }

}
