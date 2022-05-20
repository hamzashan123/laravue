<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use URL;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\File;
use App\Models\UserRole;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {       
        $Avatarurl = '';
        if (($this->avatar == 'placeholder.png')  || ($this->avatar == null)){
            $Avatarurl = URL::to('/') . Storage::disk('local')->url('public/users/placeholder.png');
        } else {
            $Avatarurl = URL::to('/') . Storage::disk('local')->url('public/users/' .$this->id . '/' . $this->avatar);
        }                

        return [            
            'id'=> $this->id,
            'firstname'=> $this->firstname,
            'middlename'=> $this->middlename,
            'lastname'=> $this->lastname,
            'userid'=> $this->userid,
            'email'=> $this->email,
            'contact'=> $this->contact,
            'address'=> $this->address,
            'dateofbirth'=> $this->dateofbirth,
            'country'=> $this->country,
            'state'=> $this->state,
            'city'=> $this->city,
            'status'=> $this->status,
            'user_role'=> $this->getUserRole,
            'avatar'=> $Avatarurl,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
