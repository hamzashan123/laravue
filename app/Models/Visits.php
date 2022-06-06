<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingImages;
use App\Models\Proposals;
use App\Models\Listing;

class Visits extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'id',
        'user_id',
        'listing_id',
        'visit_date',
        'percentage',
        'visit_summary',
        'visit_detail',
        'status',
        'updated_at',
        'created_at'
    ];   

    public function getUser() {
        return $this->hasOne(User::class,'id','user_id')
            ->select('users.*');
    }

    public function getListing() {
        return $this->hasOne(Listing::class,'id','listing_id')
            ->select('listing.*');
    }

    public function getImages() {
        return $this->hasMany(VisitImages::class,'visit_id','id')
            ->select('visit_images.*');
    }

}
