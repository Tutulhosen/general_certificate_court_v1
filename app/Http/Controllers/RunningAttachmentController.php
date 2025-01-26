<?php

namespace App\Http\Controllers;

use App\Repositories\AppealRepository;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RunningAttachmentController extends Controller
{
    public function adeshnamaAttachment(Request $request, $id = '')
    {
        $id = decrypt($id);
        // DB::beginTransaction();
        // dd($request->onama_file_type, $_FILES['onama_file_name']['name']);
        try {

            if ($request->onama_file_type && $_FILES['onama_file_name']['name']) {
                $logfiledata = AttachmentRepository::runningAppealOrder('APPEAL', $id, $causeListId = date('Y-m-d'), $request->onama_file_type, null);
            } else {
                $logfiledata = null;
            }
            // DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }

        return redirect()->route('appeal.runningAppealAttachmentCreate', ['id' => encrypt($id)])->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }
    public function adeshTempleteAttachment(Request $request, $id = '')
    {
        $id = decrypt($id);

        try {

            // dd($request->orderId, $_FILES['order_file_name']['name']);
            // exit;
            if ($request->order_file_type && $_FILES['order_file_name']['name']) {
                $orderId = $request->orderId;
                $logfiledata = AttachmentRepository::runningAppealStoreAttachment('APPEAL', $id, $causeListId = date('Y-m-d'), $request->order_file_type, null, $orderId);
            } else {
                $logfiledata = null;
            }
            // DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }

        return redirect()->route('appeal.runningAppealAttachmentCreate', ['id' => encrypt($id)])->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }
    public function attendanceAttachment(Request $request, $id = '')
    {
        $id = decrypt($id);

        try {

            // dd($request->order_file_type , $_FILES['order_file_name']['name']);
            // exit;
            if ($request->attendance_file_type && $_FILES['attendance_file_name']['name']) {
                $logfiledata = AttachmentRepository::runningAppealOrderTemplate('APPEAL', $id, $causeListId = date('Y-m-d'), $request->attendance_file_type, null);
            } else {
                $logfiledata = null;
            }
            // DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }

        return redirect()->route('appeal.runningAppealAttachmentCreate', ['id' => encrypt($id)])->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }
    public function onnannoAttachment(Request $request, $id = '')
    {
        $id = decrypt($id);

        try {

            // dd($request->order_file_type , $_FILES['order_file_name']['name']);
            // exit;
            if ($request->file_type && $_FILES['file_name']['name']) {

                //last
                $log_file_data = AttachmentRepository::onnannoStoreAttachment('APPEAL', $id, $causeListId = date('Y-m-d'), $request->file_type, null);
            } else {
                $log_file_data = null;
            }
            // DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }

        return redirect()->route('appeal.runningAppealAttachmentCreate', ['id' => encrypt($id)])->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }
}