<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Office;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\CaseRegister;
use Illuminate\Support\Arr;

class MessageController extends Controller
{
    public function messages()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $users= DB::table('users')
                ->orderBy('id','DESC')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->join('office', 'users.office_id', '=', 'office.id')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('users.*', 'role.role_name', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');
                // ->paginate(10);
        }else{
            $users= DB::table('users')
                ->orderBy('id','DESC')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->join('office', 'users.office_id', '=', 'office.id')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('users.*', 'role.role_name', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
                ->where('office.district_id', $officeInfo->district_id);
                // ->paginate(10);
        }

        // ?division=3&district=38&upazila=121

        if(!empty($_GET['division'])) {
            $users->where('office.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $users->where('office.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $users->where('office.upazila_id','=',$_GET['upazila']);
        }

        $users = $users->paginate(10);

        $page_title = 'ব্যবহারকারীর তালিকা';

        return view('messages.list', compact('page_title','users'))
        ->with('i', (request()->input('page',1) - 1) * 10);

    }
    public function messages_recent()
    {
        $user = Auth::user();

        $msgs = Message::select(DB::raw('id, user_sender, user_receiver, max(id) as mid'))
                        ->orderby('mid', 'DESC')
                        ->where('user_sender', [Auth::user()->id])
                        ->orWhere('user_receiver', [Auth::user()->id])
                        ->Where('msg_reqest', 0)
                        ->groupby(['user_receiver', 'user_sender'])
                        ->get();


        // $data['count'] = $data['msgs']->count();

        $arr = [];
        foreach($msgs as $mes){
            if(in_array($mes->user_sender, $arr) || in_array($mes->user_receiver, $arr )){
                continue;
            } else {
                if( $mes->user_sender == Auth::user()->id ){
                    array_push($arr, $mes->user_receiver);
                } else{
                    array_push($arr, $mes->user_sender);
                }
            }
        }

        $data['users'] = User::whereIn('id', $arr)
            ->orderByRaw(DB::raw('FIELD(id,' . implode(",",$arr). ')'))
            ->paginate(15);


        // return $data['users'];

        // $data['msgs'] = Message::select(DB::raw('id, user_sender, user_receiver, max(id) as mid'))
        //     ->where('user_sender',$user->id)
        //     ->orderBy('mid', 'desc')
        //     ->groupBy(['user_receiver'])
        //     ->paginate(15);

        // // $data['msg_request'] = [];
        // $data['msgs'] = Message::select('id','user_sender', 'user_receiver', 'msg_reqest')
        //     ->where('user_sender', [Auth::user()->id])
        //     // ->Where('msg_reqest', 1)
        //     ->orderby('created_at', 'DESC')
        //     // ->groupby('user_receiver')
        //     ->get();

        // $data['msgs'] = Message::orderby('id', 'DESC')
        //     // ->select('user_sender', 'user_receiver')
        //     ->where('user_sender', [Auth::user()->id])
        //     ->groupby('user_receiver')
        //     ->paginate(20);

        // $data['arr'] = [];
        // foreach($data['msgs'] as $mes){
        //     if( $mes->user_receiver != Auth::user()->id ){
        //         array_push($data['arr'], $mes->user_receiver);
        //     }
        // }
        // $data['arr'] =array_unique($data['arr']);
        // $arr =array_unique($data['arr']);
        // return $data['users'] = User::select('id')
        //                     ->whereIn('id', array_unique($data['arr']))
        //                     ->orderByRaw(DB::raw('FIELD(id,' . implode(",",$arr). ')'))
        //                     ->paginate(3);

        $data['page_title'] = 'সাম্প্রতিক বার্তা';

        return view('messages.recent')->with($data)
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    public function messages_request()
    {
        $data['msg_request'] = Message::orderby('id', 'DESC')
            // ->select('user_sender', 'user_receiver', 'msg_reqest')
            ->Where('user_receiver', [Auth::user()->id])
            ->Where('msg_reqest', 1)
            ->groupby('user_sender')
            ->paginate(15);

        $data['page_title'] = 'নতুন বার্তা অনুরোধ';
        // return $data;

        return view('messages.request')->with($data)
        ->with('i', (request()->input('page',1) - 1) * 10);


        // return view('messages.single', compact('page_title','user', 'messages'));
    }
    public function messages_single(Request $request, $user_id)
    {
        // return 'minar';
        $data['user'] = User::findOrFail($user_id);
        $data['messages'] = Message::orderby('id', 'DESC')
            ->whereIn('user_sender', [Auth::user()->id, $user_id])
            ->whereIn('user_receiver', [Auth::user()->id, $user_id])
            ->paginate(20);
        if ($request->ajax()) {
            $returnHTML = view('messages.ajaxMsg')->with($data)->render();
            return response()->json($returnHTML, 200);
            // return response()->json(['success'=>'Data is successfully added','sfdata'=>'Data is successfully added', 'html' => $returnHTML]);

            // return $returnHTML;
        }
        $msgSeen = Message::orderby('id', 'DESC')
            ->select('id', 'receiver_seen', 'seen_at')
            ->where('user_sender', $user_id)
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
        // $messages = $data['messages']->toArray();
        // // return $messages = Arr::sort($messages);
        // $data['messages'] = array_values(Arr::sort($messages['data'], function ($key, $value) {
        //     return $key;
        // }));

        // $msg =arsort($messages);
        // $messa = $messages->toArray()->sortBy('id','ASC');
        // dd(collect($messages)->sortByAsc('id'));

        $data['page_title'] = 'বার্তা বিনিময়';

        return view('messages.single')->with($data);
    }

    public function messages_remove($message_id)
    {
        $messages = Message::findOrFail($message_id);
        $messages->msg_remove = 1;
        $messages->save();

        return redirect()->back()->with(['success' => 'আপনার বার্তাটি সফলভাবে রিমুভ করা হয়েছে']);
    }

    public function messages_send(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'messages' => 'required',
        ],
        [
            'messages.required' => 'বার্তা তৈরী করুন!',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error' => $validator->errors()->first()]);
        }

        //save message
        foreach($request->receiver as $receiver){
            //find old msg request if have
            $OldMsgReq = Message::where('user_sender', $receiver)
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
            $IsMsgReq = Message::where('user_sender', $receiver)
            ->where('user_receiver', Auth::user()->id)
            ->first();
            //save new message
            $message = new Message();
            $message->messages = $request->messages;
            $message->user_sender = Auth::user()->id;
            $message->user_receiver = $receiver;
            $message->msg_reqest = $IsMsgReq != null ? 0 : 1;
            $message->ip_info = request()->ip();
            $message->save();
        }
        if($request->case_id){
            return redirect()->route('case.details', $request->case_id)->with(['success' => 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে']);;
        }
        return redirect()->back()->with(['success' => 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে']);
    }

    public function messages_group(Request $request)
    {
        $case_id= $request->c;
        $case = CaseRegister::findOrFail($case_id);
        $data['users'] = User::with('office')
                    ->whereHas('office', function($query) use ($case){
                        // $query->where('id', 7860);
                        $query->where('district_id', $case->district_id);
                        // $query->where('upazila_id', $case->upazila_id);
                    })
                    ->get();

        $data['page_title'] = 'গ্রুপ বার্তা বিনিময়';
        return view('messages.group')->with($data);
    }

    public function script(Request $request)
    {
        $mk = 'khalid';

        $offices = Office::where('office_name_bn', 'জেলা প্রশাসকের কার্যালয়')->get();
        foreach($offices as $office){
            $office->office_name_bn = 'জেলা প্রশাসকের কার্যালয়, ' . $office->district->district_name_bn;
            if($office->save()){
                $mk = 'Success';
           }
        }

        // $divs = Division::all();
        // foreach($divs as $div){
        //    $office = new Office();
        //    $office->division_id = $div->id;
        //    $office->district_id = null;
        //    $office->upazila_id = null;
        //    $office->level = 2;
        //    $office->office_name_bn = 'বিভাগীয় ভূমি কমিশনারের কার্যালয়, ' . $div->division_name_bn;
        //    $office->status = 1;
        //    if($office->save()){
        //         $mk = 'Success';
        //    }
        // }

        return $mk;
    }
}
