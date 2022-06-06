<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use URL;
use Auth;
use Illuminate\Support\Facades\File;
use App\Http\Resources\UserResource;
use App\Http\Resources\ListingResource;

class LegalDocumentsResource extends JsonResource
{
    /**s
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
              
        $document = URL::to('/') . Storage::disk('local')->url('public/ListingDocuments/' .$this->listing_id . '/' . $this->user_type . '/' . $this->legal_document_path);
        

        return [
            'id'=> $this->id,
            'user'=> new UserResource($this->getUser),           
            'legal_document_name'=> $this->legal_document_name,
            'legal_document_path'=> $document,
            'legal_document_date'=> $this->legal_document_date,
            'user_type'=> $this->user_type,
            'status'=> $this->status,
            'document_type'=> $this->document_type,            
            'notes'=> $this->notes,            
            'percentage'=> $this->percentage, 
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
