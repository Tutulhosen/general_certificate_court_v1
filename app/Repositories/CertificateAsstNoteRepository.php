<?php

namespace App\Repositories;

use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;

class CertificateAsstNoteRepository
{
    public static function store_certificate_asst_note($request_data, $appealId)
    {
        $gco_notes_id = DB::table('gco_notes_modified')->where('appeal_id', $appealId)->select('id')->orderBy('id', 'desc')->first();
        if (!empty($gcc_notes)) {
            $gco_notes_id = $gco_notes_id->id;
        } else {
            $gco_notes_id = null;
        }

        $user = globalUserInfo();
        $cer_asst_notes_modified_table = [
            'appeal_id' => $appealId,
            'gco_notes_id' => $gco_notes_id,
            'approved' => 1,
            'case_short_decision_id' => $request_data->shortOrder[0],
            'order_text' => $request_data->note,
            'conduct_date' => date('Y-m-d'),
            'next_date' => date('Y-m-d'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by_id' => $user->id,
            'created_by_name' => $user->name,
            'created_by_office' => $user->office->office_name_bn,
            'created_by_designation' => $user->role->role_name,
        ];

        $certificate_asst_note_id = DB::table('cer_asst_notes_modified')->insertGetId($cer_asst_notes_modified_table);

        DB::table('gcc_appeals')->where('id', $appealId)->update([
            'action_required' => 'GCO',
        ]);

        return $certificate_asst_note_id;
    }
    public static function get_order_list($appealId)
    {
        return DB::table('gcc_notes_modified')
            ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', 'gcc_case_shortdecisions.id')
            ->where('gcc_notes_modified.appeal_id', $appealId)
            ->select('gcc_notes_modified.conduct_date as conduct_date', 'gcc_case_shortdecisions.case_short_decision as short_order_name')
            ->get();
    }

    public static function get_last_order_list($appealId)
    {
        return DB::table('gcc_notes_modified')
            ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', 'gcc_case_shortdecisions.id')
            ->where('gcc_notes_modified.appeal_id', $appealId)
            ->select('gcc_notes_modified.conduct_date as conduct_date', 'gcc_case_shortdecisions.case_short_decision as short_order_name','gcc_notes_modified.manual_short_decision as manual_decision_name')
            ->orderBy('gcc_notes_modified.id', 'desc')
            ->first();
    }

    public static function generate_order_shit($appealId)
    {
        // dd($appealId);

        $gcc_notes = DB::table('gcc_notes_modified')->where('appeal_id', $appealId)->get();

        if (count($gcc_notes) > 0) {
            $shortoder_array = [];
            foreach ($gcc_notes as $key => $value) {
                if ($key == 0) {
                    $start_date = $value->conduct_date;
                }
                if ($key == sizeof($gcc_notes) - 1) {
                    $end_date = $value->conduct_date;
                }
                $get_corresponding_certificate_asst = DB::table('cer_asst_notes_modified')->where('id', $value->certificate_asst_notes_id)->select('order_text')->first();

                $single_pair['order_date'] = date_formater_helpers_make_bd_v2($value->conduct_date);
                $single_pair['gcc_name'] = $value->created_by_name;
                $single_pair['gcc_signature'] = url('/') . self::userSignature($value->created_by_id)->signature;
                $single_pair['designation'] = $value->created_by_designation;
                $single_pair['certificate_asst_order'] = $get_corresponding_certificate_asst->order_text;
                $single_pair['gcc_order'] = $value->order_text;

                array_push($shortoder_array, $single_pair);
            }

            $data = [
                'case_info' => AppealRepository::getCauselistCitizen($appealId),
                'case_District' => self::caseDistrict($appealId),
                'case_Upzilla' => self::caseUpzilla($appealId),
                'ordershit_start_date' => date_formater_helpers_make_bd_v2($start_date),
                'ordershit_end_date' => date_formater_helpers_make_bd_v2($end_date),
                'shortoder_array_date' => $shortoder_array,
            ];

            return $data;
        }

        return;
    }
    public static function userSignature($user_id)
    {
        return DB::table('users')->where('id', $user_id)->select('signature')->first();
    }
    public static function caseDistrict($appealId)
    {

        return DB::table('district')->join('gcc_appeals', 'gcc_appeals.district_id', 'district.id')->where('gcc_appeals.id', $appealId)->select('district.district_name_bn')->first()->district_name_bn;
    }
    public static function caseUpzilla($appealId)
    {
        return DB::table('upazila')->join('gcc_appeals', 'gcc_appeals.upazila_id', 'upazila.id')->where('gcc_appeals.id', $appealId)->select('upazila.upazila_name_bn')->first()->upazila_name_bn;
    }

    public static function order_list($appealId)
    {

        $gcc_notes = DB::table('gcc_notes_modified')->where('appeal_id', $appealId)->get();

        if (count($gcc_notes) > 0) {
            $shortoder_array = [];
            foreach ($gcc_notes as $key => $value) {
                if ($key == 0) {
                    $start_date = $value->conduct_date;
                }
                if ($key == sizeof($gcc_notes) - 1) {
                    $end_date = $value->conduct_date;
                }
                $get_corresponding_certificate_asst = DB::table('cer_asst_notes_modified')->where('id', $value->certificate_asst_notes_id)->first();

                $single_pair['gcc_order_date'] = date_formater_helpers_make_bd_v2($value->conduct_date);
                $single_pair['certificate_asst_order'] = $get_corresponding_certificate_asst->order_text;
                $single_pair['gcc_order'] = $value->order_text;
                $single_pair['certificate_asst_files_files'] = $get_corresponding_certificate_asst->cer_asst_attachmets;
                $single_pair['gcc_files'] = $value->gcc_attachmets;
                $single_pair['order_date_certificate_asst'] = date_formater_helpers_make_bd_v2($get_corresponding_certificate_asst->conduct_date);

                array_push($shortoder_array, $single_pair);
            }

            //dd($shortoder_array);

            return $shortoder_array;
        }

        return;
    }
    public static function certificate_asst_initial_comments($appealId)
    {
        $get_corresponding_certificate_asst = DB::table('cer_asst_notes_modified')->where('appeal_id', $appealId)->orderBy('id', 'desc')->first();
        //dd($get_corresponding_certificate_asst);

        if (!empty($get_corresponding_certificate_asst)) {
            return [
                'certificate_asst_order' => $get_corresponding_certificate_asst->order_text,
                'order_date_certificate_asst' => date_formater_helpers_make_bd_v2($get_corresponding_certificate_asst->conduct_date),
                'certificate_asst_files' => $get_corresponding_certificate_asst->cer_asst_attachmets,

            ];
        } else {
            return null;
        }
    }
    public static function gcc_last_order($appealId)
    {
        $get_corresponding_gcc = DB::table('gcc_notes_modified')->where('appeal_id', $appealId)->orderBy('id', 'desc')->first();
        if (!empty($get_corresponding_gcc)) {
            return [
                'gcc_order' => $get_corresponding_gcc->order_text,
                'order_date_gcc' => date_formater_helpers_make_bd_v2($get_corresponding_gcc->conduct_date),
                'gcc_files' => $get_corresponding_gcc->gcc_attachmets,

            ];
        } else {
            return null;
        }
    }
    public static function collection_payment_so_far($appealId)
    {
        return DB::table('gcc_payment_lists')->where('appeal_id', $appealId)->sum('paid_loan_amount');
    }
    public static function storePaymentInfo($request_data, $appealId)
    {
        return DB::table('gcc_payment_lists')->insertGetId([
            'appeal_id' => $appealId,
            'paid_loan_amount' => bn2en($request_data->TodayPaymentPaymentCollection),
            // 'payble_amount' => bn2en($request_data->TotalRemainingPaymentPaymentCollection),
            'paid_date' => date('Y-m-d')
        ]);
    }
}
