<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImages extends Model
{
    protected $table = 'listing_images';

    protected $fillable = [
        'id',
        'listing_id',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];

}
