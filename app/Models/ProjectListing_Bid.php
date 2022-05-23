<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\CreateListing;

class ProjectListing_Bid extends Model
{
    protected $table = 'project_listing_bid';

    protected $fillable = [
        'id',
        'clientid',
        'listingid',
        'contractorid',
        'budget',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getClinet() {
        return $this->hasOne(User::class,'id','clientid')
            ->select('users.*');
    }

    public function getContractor() {
        return $this->hasOne(User::class,'id','contractorid')
            ->select('users.*');
    }

    public function getListing() {
        return $this->hasOne(CreateListing::class,'id','listingid')
            ->select('create_listing.*');
    }

}
