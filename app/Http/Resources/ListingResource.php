<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\ListingImagesResource;
use App\Http\Resources\UserResource;

class ListingResource extends JsonResource
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
            'userid'=> new UserResource($this->getUser),
            'name'=> $this->name,
            'target_completion_datefrom'=> $this->target_completion_datefrom,
            'target_completion_dateto'=> $this->target_completion_dateto,
            'minimum_budget'=> $this->minimum_budget,
            'maximum_budget'=> $this->maximum_budget,
            'detail'=> $this->detail,
            'address_line1'=> $this->address_line1,
            'address_line2'=> $this->address_line2,
            'country'=> $this->country,
            'state'=> $this->state,
            'district'=> $this->district,
            'status'=> $this->status,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'images'=> ListingImagesResource::collection($this->getImages),
        ];
    }
}
