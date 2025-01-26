<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'messages',
        'user_sender',
        'user_receiver',
        'receiver_seen',
        'seen_at',
        'msg_reqest',
        'ip_info',
    ];
    public function sender(){
        return $this->hasOne(User::class, 'id', 'user_sender');
    }
    public function receiver(){
        return $this->hasOne(User::class, 'id', 'user_receiver');
    }
    public function role(){
        return $this->hasOne(Role::class, 'id', 'receiver', 'role_id');
    }
    // public function lastMessages($id) {
    //     return $this->hasMany(Message::class, 'user_receiver', 'user_receiver')
    //          ->select('id','user_sender', 'user_receiver', 'msg_reqest')
    //          ->join(DB::raw('(Select max(id) as id from messages group by user_receiver) LatestMessage'), function($join) {
    //             $join->on('messages.id', '=', 'LatestMessage.id');
    //             })
    //          ->orderBy('created_at', 'desc');
    // }
    // public function lastMessages() {
    //     return $this->hasMany(Message::class, 'user_receiver')
    //          ->select('*')
    //          ->join(DB::raw('(Select max(id) as id from messages group by user_receiver) LatestMessage'), function($join) {
    //             $join->on('messages.id', '=', 'LatestMessage.id');
    //             })
    //          ->orderBy('created_at', 'desc');
    // }
}
