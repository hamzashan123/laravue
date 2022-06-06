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
        'document_type',
        'notes',
        'percentage',
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

    public function getLegalClientDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','listing_id')
            ->where('user_type','client')->where('document_type','legal')
            ->select('listing_documents.*');
    }

    public function getLegalContractorDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','listing_id')
            ->where('user_type','contractor')->where('document_type','legal')
            ->select('listing_documents.*');
    }

    public function getFinanceClientDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','listing_id')
            ->where('user_type','client')->where('document_type','finance')
            ->select('listing_documents.*');
    }

    public function getFinanceContractorDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','listing_id')
            ->where('user_type','contractor')->where('document_type','finance')
            ->select('listing_documents.*');
    }
}
