<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\UserResource;

class MessageResource extends JsonResource
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
            'from_user'=> $this->getFromUser->first_name . ' ' . $this->getFromUser->last_name,
            'to_user'=> $this->getToUser->first_name . ' ' . $this->getToUser->last_name,
            'message' => $this->message,
            'seen' => $this->seen,
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
