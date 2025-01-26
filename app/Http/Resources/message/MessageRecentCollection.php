<?php

namespace App\Http\Resources\message;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageRecentCollection extends JsonResource
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
            'id' => $this->receiver->id,
            'unseen_msg' => Message::select('id')
                                ->where('user_sender', $this->receiver->id)
                                ->where('user_receiver', Auth::user()->id)
                                ->where('receiver_seen', 0)
                                ->count(),
            'name' => $this->receiver->name,
            'username' => $this->receiver->username,
            'email' => $this->receiver->email,
            'mobile_no' => $this->receiver->mobile_no,
            // 'profile_pic' => $this->receiver->profile_pic == null ? null : url('/') .'/uploads/profile/' . $this->receiver->profile_pic,
            'profile_pic' => url('/') .'/uploads/profile/' . $this->receiver->profile_pic,
            'role_name' => $this->receiver->role->role_name,
            'office_name' => $this->receiver->office->office_name_bn,
            'district_name' => $this->receiver->office->dis_name_bn,
            'upazila_name' => $this->receiver->office->upa_name_bn,
            'href' => route('messages.single', $this->user_receiver),
        ];
    }
}
