<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'listing'=> new ListingResource($this->getListing),
            'contractor' => new UserResource($this->getContractor),
            'status'=> $this->status,
            'assigned_by' => new UserResource($this->getAssignedBy),
            'description'=> $this->description,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
