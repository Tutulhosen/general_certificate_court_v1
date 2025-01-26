<?php

namespace App\Http\Resources\message;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'unseen_msg' => null,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'profile_pic' => $this->profile_pic == null ? null : url('/') .'/uploads/profile/' . $this->profile_pic,
            'role_name' => $this->role->role_name,
            'office_name' => $this->office->office_name_bn,
            'district_name' => $this->office->dis_name_bn,
            'upazila_name' => $this->office->upa_name_bn,
            'href' => route('messages.single', $this->id),
        ];
    }
}
