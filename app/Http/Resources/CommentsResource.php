<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserResource;

class CommentsResource extends JsonResource
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
            'user_name'=> $this->getUser->first_name . ' ' . $this->getUser->last_name,
            'user_role'=> $this->getUser->getUserRole->role,
            'message' => $this->message,            
            'listing_id' => $this->getListing->id,
            'listing_title' => $this->getListing->title,
            'my_message' => ($this->getUser->id == Auth::user()->id ? true : false),
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
