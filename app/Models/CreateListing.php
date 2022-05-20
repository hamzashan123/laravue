<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateListing extends Model
{
    protected $table = 'create_listing';

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

}
