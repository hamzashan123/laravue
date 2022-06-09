<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\VisitImagesResource;
use Illuminate\Support\Facades\Storage;

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

        $ImageArray = [];
        $rownumber = 1;
        foreach ($this->getImages as $image) {         

            $imageurl = '';
            if (($image->image == 'placeholder.png')  || ($image->image == null)){
                $imageurl = URL::to('/') . Storage::disk('local')->url('public/users/placeholder.png');
            } else {
                $imageurl = URL::to('/') . Storage::disk('local')->url('public/Visit/' .$image->visit_id  . '/images/' . $image->image);
            }

            $ImageArray["image" . $rownumber] = $imageurl;
            $rownumber = ($rownumber + 1);
        }

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
            //'images'=> VisitImagesResource::collection($this->getImages),
            'images'=> $ImageArray,
        ];
    }
}
