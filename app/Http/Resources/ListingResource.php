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
            'user'=> new UserResource($this->getUser),
            'title'=> $this->title,
            'target_completion_datefrom'=> $this->target_completion_datefrom,
            'target_completion_dateto'=> $this->target_completion_dateto,
            'min_budget'=> $this->min_budget,
            'max_budget'=> $this->max_budget,
            'description'=> $this->description,
            'address_line1'=> $this->address_line1,
            'address_line2'=> $this->address_line2,
            'country'=> $this->country,
            'state'=> $this->state,
            'district'=> $this->district,
            'published_by' => new UserResource($this->getPublishBy) ?? null,
            'status'=> $this->status,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'images'=> ListingImagesResource::collection($this->getImages),
        ];
    }
}
