<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\ListingResource;

class ProposalsResource extends JsonResource
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
            'listing'=> new ListingResource($this->getListing),
            'contractor'=> new UserResource($this->getContractor),
            'min_budget'=> $this->min_budget,
            'max_budget'=> $this->max_budget,
            'target_startdate'=> $this->target_startdate,
            'target_enddate'=> $this->target_enddate,
            'approved_by'=> new UserResource($this->getApprovedBy) ?? null,
            'rejected_by'=> new UserResource($this->getRejectBy) ?? null,            
            'status'=> $this->status,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
