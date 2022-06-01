<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
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
        return [
            'id'=> $this->id,
            'user'=> new UserResource($this->getUser),
            'listing'=> new ListingResource($this->getListing),
            'legal_document_name'=> $this->legal_document_name,
            'legal_document_path'=> $this->legal_document_path,
            'legal_document_date'=> $this->legal_document_date,
            'user_type'=> $this->user_type,
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
