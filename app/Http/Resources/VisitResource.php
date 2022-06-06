<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\VisitImagesResource;

class VisitResource extends JsonResource
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
            'visit_date'=> $this->visit_date,
            'percentage'=> $this->percentage,
            'visit_summary'=> $this->visit_summary,
            'visit_detail'=> $this->visit_detail,
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'images'=> VisitImagesResource::collection($this->getImages),
        ];
    }
}
