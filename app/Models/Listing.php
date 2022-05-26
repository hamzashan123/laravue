<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingImages;

class Listing extends Model
{
    protected $table = 'listing';

    protected $fillable = [
        'id',
        'userid',
        'name',
        'target_completion_datefrom',
        'target_completion_dateto',
        'minimum_budget',
        'maximum_budget',
        'detail',
        'address_line1',
        'address_line2',
        'country',
        'state',
        'district',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getImages() {
        return $this->hasMany(ListingImages::class,'listing_id','id')
            ->select('listing_images.*');
    }

    public function getUser() {
        return $this->hasOne(User::class,'id','userid')
            ->select('users.*');
    }

}
