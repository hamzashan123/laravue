<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingImages;
use App\Models\Proposals;
use App\Models\Contracts;
use App\Models\LegalDocuments;
//use App\Models\Auth;
use Illuminate\Support\Facades\Auth;

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
            ->select('listing_images.*')->where('status','active');
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

    public function getContracts() {
        return $this->hasOne(Contracts::class,'listing_id','id')
            ->select('contracts.*');
    }

    public function getLegalClientDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','id')
            ->where('user_type','client')->where('document_type','legal')
            ->select('listing_documents.*');
    }

    public function getLegalContractorDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','id')
            ->where('user_type','contractor')->where('document_type','legal')
            ->select('listing_documents.*');
    }

    public function getFinanceClientDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','id')
            ->where('user_type','client')->where('document_type','finance')
            ->select('listing_documents.*');
    }

    public function getFinanceContractorDocuments() {
        return $this->hasMany(LegalDocuments::class,'listing_id','id')
            ->where('user_type','contractor')->where('document_type','finance')
            ->select('listing_documents.*');
    }
}
