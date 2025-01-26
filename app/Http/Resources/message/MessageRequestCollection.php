<?php

namespace App\Http\Resources\message;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageRequestCollection extends JsonResource
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
            'id' => $this->sender->id,
            'unseen_msg' => Message::select('id')
                                ->where('user_sender', $this->sender->id)
                                ->where('user_receiver', Auth::user()->id)
                                ->where('receiver_seen', 0)
                                ->count(),

            'name' => $this->sender->name,
            'username' => $this->sender->username,
            'email' => $this->sender->email,
            'mobile_no' => $this->receiver->mobile_no,
            // 'profile_pic' => $this->receiver->profile_pic == null ? null : url('/') .'/uploads/profile/' . $this->receiver->profile_pic,
            'profile_pic' => url('/') .'/uploads/profile/' . $this->receiver->profile_pic,
            'role_name' => $this->sender->role->role_name,
            'office_name' => $this->sender->office->office_name_bn,
            'district_name' => $this->sender->office->dis_name_bn,
            'upazila_name' => $this->sender->office->upa_name_bn,
            'href' => route('messages.single', $this->user_receiver),
        ];
    }
}
