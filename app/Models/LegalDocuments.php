<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingImages;
use App\Models\Proposals;
use App\Models\Listing;

class LegalDocuments extends Model
{
    protected $table = 'listing_documents';

    protected $fillable = [
        'id',
        'user_id',
        'listing_id',
        'legal_document_name',
        'legal_document_path',
        'legal_document_date',
        'user_type',
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

}
