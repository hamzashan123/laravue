<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use URL;
use Auth;
use Illuminate\Support\Facades\File;
use App\Http\Resources\UserResource;
use App\Http\Resources\ListingResource;

class LegalDocumentImagesResource extends JsonResource
{
    /**s
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        //dd($this->getLegalDocuments[0]->listing_id);

        $document = URL::to('/') . Storage::disk('local')->url('public/ListingDocuments/' . $this->getLegalDocuments[0]->listing_id . 
        '/' . $this->getLegalDocuments[0]->user_type . '/' . $this->legal_document_path);
        
        return [
            'id'=> $this->id,
            'listing_document_id'=> $this->listing_document_id,                  
            'legal_document_name'=> $this->legal_document_name,
            'legal_document_path'=> $document,
            'legal_document_date'=> $this->legal_document_date,            
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
