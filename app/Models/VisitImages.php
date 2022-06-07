<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VisitImages extends Model
{
    protected $table = 'visit_images';

    protected $fillable = [
        'id',
        'visit_id',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];   
}
