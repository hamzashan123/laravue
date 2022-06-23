<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Auth;
use App\Http\Resources\UserResource;

class NotificationResource extends JsonResource
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
            'user'=> $this->getUser->first_name . ' ' . $this->getUser->last_name,            
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'seen' => $this->seen,
            'status'=> $this->status,            
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
