<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use App\Http\Resources\message\MessageRecentCollection;
use App\Http\Resources\message\UserCollection;
use App\Http\Resources\message\MessageRequestCollection;
use App\Http\Resources\message\MessageGroupCollection;
use App\Models\CaseRegister;

class MessageController extends BaseController
{
    public function messages(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        if( $roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $users = User::orderBy('id','DESC');
            // $users->paginate(10);
        } else {
            $district_id = $officeInfo->district_id;
            $users = User::orderBy('id','DESC')
            ->whereHas('office', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
            // ->paginate(10);
        }

        if($request->division) {
            $users->whereHas('office', function ($query) use ($request) {
                $query->where('division_id', $request->division);
            });
        }
        if($request->district) {
            $users->whereHas('office', function ($query) use ($request) {
                $query->where('district_id', $request->district);
            });
        }
        if($request->upazila) {
            $users->whereHas('office', function ($query) use ($request) {
                $query->where('upazila_id', $request->upazila);
            });
        }

        $data = UserCollection::collection($users->paginate(10));
        return $this->NewSendResponse($data, 'Messages All User List.');

    }
    public function messages_recent(Request $request)
    {
        $user = Auth::user();
        $msgs = Message::select(DB::raw('id, user_sender, user_receiver, max(id) as mid'))
            ->where('user_sender',$user->id)
            ->orderBy('mid', 'desc')
            ->groupBy(['user_receiver']);
            // ->paginate(15);

        // $msgs = Message::orderby('id', 'DESC')
        //     ->select("user_sender","user_receiver", "msg_reqest")
        //     ->where('user_sender', [Auth::user()->id])
        //     ->groupby('user_receiver');
            // ->paginate(10);

        if($request->division) {
            $msgs->whereHas('receiver.office', function ($query) use ($request) {
                $query->where('division_id', $request->division);
            });
        }
        if($request->district) {
            $msgs->whereHas('receiver.office', function ($query) use ($request) {
                $query->where('district_id', $request->district);
            });
        }
        if($request->upazila) {
            $msgs->whereHas('receiver.office', function ($query) use ($request) {
                $query->where('upazila_id', $request->upazila);
            });
        }


        $data = MessageRecentCollection::collection($msgs->paginate(10));
        return $this->NewSendResponse($data, 'Messages Recent User list.');
    }

    public function messages_request(Request $request)
    {
        $msg_request = Message::orderby('id', 'DESC')
            ->Where('user_receiver', [Auth::user()->id])
            ->Where('msg_reqest', 1)
            ->groupby('user_sender');
            // ->paginate(10);

        if($request->division) {
            $msg_request->whereHas('sender.office', function ($query) use ($request) {
                $query->where('division_id', $request->division);
            });
        }
        if($request->district) {
            $msg_request->whereHas('sender.office', function ($query) use ($request) {
                $query->where('district_id', $request->district);
            });
        }
        if($request->upazila) {
            $msg_request->whereHas('sender.office', function ($query) use ($request) {
                $query->where('upazila_id', $request->upazila);
            });
        }

        $data = MessageRequestCollection::collection($msg_request->paginate(10));
        return $this->NewSendResponse($data, 'User Message Request List.');
    }

    public function messages_single($user_id)
    {
        $user = User::findOrFail($user_id);
        $msgSeen = Message::orderby('id', 'DESC')
            ->select('id', 'receiver_seen', 'seen_at')
            ->where('user_sender', $user->id)
            ->where('user_receiver', Auth::user()->id)
            ->where('receiver_seen', 0)
            ->get();

        if(count($msgSeen) != 0){
            foreach($msgSeen as $msgSee){
                $msg = Message::findOrFail($msgSee->id);
                $msg->receiver_seen = 1;
                $msg->seen_at = Carbon::now()->toDateTimeString();
                $msg->save();
            }
        }

        $messages = Message::orderby('id', 'DESC')
            ->whereIn('user_sender', [Auth::user()->id, $user->id])
            ->whereIn('user_receiver', [Auth::user()->id, $user->id])
            ->paginate(15);

        return $this->sendResponse($messages, 'Single User Messageses List.');


    }
    public function messages_remove($message_id)
    {
        $messages = Message::findOrFail($message_id);
        $messages->msg_remove = 1;
        $messages->save();
        return $this->sendResponse('', 'Message Removed Successfully.');
    }

    public function messages_send(Request $request)
    {
        $request = $request->json()->all();

        //test
        // return $request['receiver'];
        // $mk = '';
        // foreach($request['receiver'] as $key => $rec ){
        //     $mk .=  $rec['id'];
        // }
        // return $mk;

        // validation
        $validator = Validator::make($request, [
            'messages' => 'required',
            'receiver' => 'required',
        ],
        [
            'messages.required' => 'বার্তা তৈরী করুন!',
            'receiver.required' => 'অনুগ্রহ করে রিসিভার ব্যবহারকারী নির্বাচন করুন!',
        ]);

        if($validator->fails()){
            return $this->sendError('Error.', ['error'=> $validator->errors()->first()]);
        }

        foreach($request['receiver'] as $receiver){
            //find old msg request if have
            $OldMsgReq = Message::where('user_sender', $receiver['id'])
            ->where('user_receiver', Auth::user()->id)
            ->where('msg_reqest', 1)
            ->get();
            //update old msg request to - not msg request
            if( count($OldMsgReq) != 0 ){
                foreach($OldMsgReq as $oMsg){
                    $msg = Message::findOrFail($oMsg->id);
                    $msg->msg_reqest = 0;
                    $msg->save();
                }
            }
            //check is msg request?
            $IsMsgReq = Message::where('user_sender', $receiver['id'])
            ->where('user_receiver', Auth::user()->id)
            ->first();
            //save new message
            $message = new Message();
            $message->messages = $request['messages'];
            $message->user_sender = Auth::user()->id;
            $message->user_receiver = $receiver['id'];
            $message->msg_reqest = $IsMsgReq != null ? 0 : 1;
            $message->ip_info = request()->ip();
            $message->save();
        }

        return $this->sendResponse('', 'Message Send Successfully.');

        // $OldMsgReq = Message::where('user_sender', $request->receiver)
        // ->where('user_receiver', Auth::user()->id)
        // ->where('msg_reqest', 1)
        // ->get();
        // //update old msg request to - not msg request
        // if( count($OldMsgReq) != 0 ){
        //     foreach($OldMsgReq as $oMsg){
        //         $msg = Message::findOrFail($oMsg->id);
        //         $msg->msg_reqest = 0;
        //         $msg->save();
        //     }
        // }
        // //check is msg request?
        // $IsMsgReq = Message::where('user_sender', $request->receiver)
        //     ->where('user_receiver', Auth::user()->id)
        //     ->first();
        // //save new message
        // $message = new Message();
        // $message->messages = $request->messages;
        // $message->user_sender = Auth::user()->id;
        // $message->user_receiver = $request->receiver;
        // $message->msg_reqest = $IsMsgReq != null ? 0 : 1;
        // $message->ip_info = request()->ip();
        // $message->save();

    }

    public function messages_groups(Request $request){
        // return $request->all();
        $case_id= $request->case_id;
        $case = CaseRegister::findOrFail($case_id, ['id', 'case_number', 'district_id']);
        $users = User::whereHas('office', function($query) use ($case){
                                $query->where('district_id', $case->district_id);
                            })
                            ->get();
        $data = MessageGroupCollection::collection($users);
        return $this->groupUserResponse($data, 'Messages Recent User list.', $case);
    }
}
