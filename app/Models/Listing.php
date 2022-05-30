<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingImages;
use App\Models\Proposals;

class Listing extends Model
{
    protected $table = 'listing';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'target_completion_datefrom',
        'target_completion_dateto',
        'min_budget',
        'max_budget',
        'description',
        'address_line1',
        'address_line2',
        'country',
        'state',
        'district',
        'published_by',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getImages() {
        return $this->hasMany(ListingImages::class,'listing_id','id')
            ->select('listing_images.*');
    }

    public function getUser() {
        return $this->hasOne(User::class,'id','user_id')
            ->select('users.*');
    }

    public function getPublishBy() {
        return $this->hasOne(User::class,'id','published_by')
            ->select('users.*');
    }

    public function getListingProposals() {
        return $this->hasMany(Proposals::class,'listing_id','id')
            ->select('proposals.*');
    }

}
