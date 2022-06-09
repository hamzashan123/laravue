<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\ListingImagesResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class GetProposalResource extends JsonResource
{
    /**
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
                $imageurl = URL::to('/') . Storage::disk('local')->url('public/Listing/' .$image->listing_id  . '/images/' . $image->image);
            }

            $ImageArray["image" . $rownumber] = $imageurl;
            $rownumber = ($rownumber + 1);
        }

        if(Auth::user()->role_id == 2) {
            $proposalCount = $this->getListingProposals->where('user_id', Auth::user()->id)->count();
        } else {
            $proposalCount = $this->getListingProposals->count();
        }

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
            //'images'=> ListingImagesResource::collection($this->getImages),
            'images'=> $ImageArray,
            'proposals'=> $proposalCount,
        ];
    }
}
