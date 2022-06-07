<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\User;

class Contracts extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'id',
        'listing_id',    
        'contractor_id',        
        'status',
        'assigned_by',
        'description',
        'created_at',
        'updated_at'
    ];

    public function getListing() {
        return $this->hasOne(Listing::class,'id','listing_id')
            ->select('listing.*');
    }

    public function getContractor() {
        return $this->hasOne(User::class,'id','contractor_id')
            ->select('users.*');
    }

    public function getAssignedBy() {
        return $this->hasOne(User::class,'id','assigned_by')
            ->select('users.*');
    }
    

}
