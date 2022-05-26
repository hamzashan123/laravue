<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use URL;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\File;
use App\Models\UserRole;
class ListingImagesResource extends JsonResource
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
        if (($this->image == 'placeholder.png')  || ($this->image == null)){
            $Avatarurl = URL::to('/') . Storage::disk('local')->url('public/users/placeholder.png');
        } else {
            $Avatarurl = URL::to('/') . Storage::disk('local')->url('public/Listing/' .$this->listing_id  . '/images/' . $this->image);
        }

        return [
            'image'=> $Avatarurl
        ];
    }
}
