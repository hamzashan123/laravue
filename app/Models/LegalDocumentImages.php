<?php

namespace App\Models;
use App\Models\LegalDocuments;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentImages extends Model
{
    protected $table = 'listing_document_images';

    protected $fillable = [
        'id',
        'listing_document_id',
        'legal_document_name',       
        'legal_document_path',
        'legal_document_date',
        'status',        
        'updated_at',
        'created_at'
    ];

    public function getLegalDocuments() {
        return $this->hasMany(LegalDocuments::class,'id','listing_document_id')            
            ->select('listing_documents.*');
    }
}
