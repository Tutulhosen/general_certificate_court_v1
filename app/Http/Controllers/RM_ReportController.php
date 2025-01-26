<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RM_ReportController extends Controller
{
    public function caselist()
    {
          // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0,0,0));

        $data['page_title'] = 'রাজস্ব মামলার রিপোর্ট ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('rm_report.caselist')->with($data);
    }

    public function pdf_generate(Request $request)
    {
        // return $request;
      // dd($request->all());
      // Case List Report
      if($request->btnsubmit == 'pdf_case'){
         $data['page_title'] = 'রাজস্ব মামলার তালিকা'; //exit;
         $data['date_start'] = $request->date_start;
         $data['date_end'] = $request->date_end;
         $data['division'] = $request->division;
         $data['district'] = $request->district;

         // Validation
         $request->validate(
          ['date_start' => 'required', 'date_end' => 'required'],
          ['date_start.required' => 'মামলা শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => 'মামলা শেষের তারিখ নির্বাচন করুন']
          );

         // Get Division
         // $data['court'] = DB::table('court')->select('id', 'court_name')->where('id', $request->court)->first();
         $data['results'] = $this->case_list_filter($data);
         // dd($data['court']);

         $html = view('rm_report.pdf_case')->with($data);
         // Generate PDF
         $this->generatePDF($html);
       }

      // User RoleWise Case List Report
      if($request->btnsubmit == 'pdf_userrolewise'){
         $data['page_title'] = 'রাজস্ব মামলার তালিকা'; //exit;
         $data['division'] = $request->division;
         $data['district'] = $request->district;
         $data['upazila'] = $request->upazila;
         $data['role'] = $request->role;

         // Validation
         $request->validate(
          ['role' => 'required', 'division' => 'required', 'district' => 'required'],
          ['role.required' => 'ইউজার রোল নির্বাচন করুন', 'division.required' => 'বিভাগ নির্বাচন করুন', 'district.required' => 'জেলা নির্বাচন করুন']
          );

         // Get Division
         // $data['court'] = DB::table('court')->select('id', 'court_name')->where('id', $request->court)->first();
         $data['results'] = $this->case_list_role_filter($data);

         // dd($data['results']);

         $html = view('rm_report.pdf_userrolewise')->with($data);
         // Generate PDF
         $this->generatePDF($html);
       }

      // Courtwise Report
       if($request->btnsubmit == 'pdf_courtwise'){
         $data['page_title'] = 'আদালত ভিত্তিক রাজস্ব মামলার রিপোর্ট'; //exit;
         $data['results'] = array();
         // Validation
         $request->validate(
          ['division' => 'required'],
          ['division.required' => 'বিভাগ নির্বাচন করুন']
          );
         $data['court_name'] = $request->court;
         // dd($data['court_name']);
         // Get Division
         $query = DB::table('court')
         ->select('court.id', 'court.court_name', 'district.district_name_bn')
         ->join('district', 'court.district_id', '=', 'district.id')
         ->where('court.division_id', $request->division);
         if ($request->court) {
          $query->where('court.id', $request->court);
         }
         $data['court'] = $query->get();

         // dd( $data['court']);

         foreach ($data['court'] as $key => $value) {
            $data['results'][$key]['court_name'] = $value->court_name;
            $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
            $data['results'][$key]['total_case'] = $this->case_count_by_court($value->id);
            $data['results'][$key]['running_case'] = $this->case_count_by_court_status($value->id, 1, $data);
            $data['results'][$key]['appeal_case'] = $this->case_count_by_court_status($value->id, 2, $data);
            $data['results'][$key]['completed_case'] = $this->case_count_by_court_status($value->id, 3, $data);
          }

         // $data['results'] = $this->case_courtwise($request->division);
         // dd($data['results']);

          $html = view('rm_report.pdf_courtwise')->with($data);
         // Generate PDF
          $this->generatePDF($html);
        }

        if($request->btnsubmit == 'pdf_num_division'){
         $data['page_title'] = 'বিভাগ ভিত্তিক রাজস্ব মামলার রিপোর্ট'; //exit;

         // Get Division
         // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
         $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

          $data['year'] = $request->year;
          $data['month'] = $request->month;

         foreach ($data['divisions'] as $key => $value) {
          $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
          $data['results'][$key]['running'] = $this->case_count_status_by_division(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_division(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_division(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_division_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_division_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data['results']);

        $html = view('rm_report.pdf_num_division')->with($data);
        // dd($html);
         // Generate PDF
        $this->generatePDF($html);
      }


        if($request->btnsubmit == 'pdf_num_division_year'){
         $data['page_title'] = 'বিভাগ ভিত্তিক রাজস্ব মামলার বার্ষিক রিপোর্ট'; //exit;

         // Get Division
         // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
         $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();


         $request->validate([
          'year' => 'required',
          ],
          [
          'year.required' => 'সাল নির্বাচন করুন',
          ]);

          $data['year'] = $request->year;
          $data['month'] = $request->month;


         foreach ($data['divisions'] as $key => $value) {
          $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
          $data['results'][$key]['running'] = $this->case_count_status_by_division(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_division(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_division(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_division_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_division_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data['results']);

        $html = view('rm_report.pdf_num_division')->with($data);
        // dd($html);
         // Generate PDF
        $this->generatePDF($html);
      }


        if($request->btnsubmit == 'pdf_num_division_month'){
         $data['page_title'] = 'বিভাগ ভিত্তিক রাজস্ব মামলার মাসিক রিপোর্ট'; //exit;

         // Get Division
         // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
         $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
          $request->validate([
          'year' => 'required',
          'month' => 'required',
          ],
          [
          'year.required' => 'সাল নির্বাচন করুন',
          'month.required' => 'মাস নির্বাচন করুন',
          ]);
          $data['year'] = $request->year;
          $data['month'] = $request->month;

         foreach ($data['divisions'] as $key => $value) {
          $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
          $data['results'][$key]['running'] = $this->case_count_status_by_division(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_division(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_division(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_division_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_division_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data['results']);

        $html = view('rm_report.pdf_num_division')->with($data);
        // dd($html);
         // Generate PDF
        $this->generatePDF($html);
      }

      // District
      if($request->btnsubmit == 'pdf_num_district'){
         $data['page_title'] = 'জেলা ভিত্তিক রাজস্ব মামলার রিপোর্ট'; //exit;

         // Validation
         $request->validate(
          ['division' => 'required',],
          ['division.required' => 'বিভাগ নির্বাচন করুন']
          );

         $data['year'] = $request->year;
         $data['month'] = $request->month;

         // Get Division
         $data['district_list'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
         // dd($request->division);->count()

          foreach ($data['district_list'] as $item) {
            $data_arr[$item->id]['running'] = $this->case_count_status_by_district(1, $item->id, $data);
            $data_arr[$item->id]['appeal'] = $this->case_count_status_by_district(2, $item->id, $data);
            $data_arr[$item->id]['closed'] = $this->case_count_status_by_district(3, $item->id, $data);
            $data_arr[$item->id]['win'] = $this->case_count_status_by_district_result_win(3, $item->id, $data);
            $data_arr[$item->id]['lost'] = $this->case_count_status_by_district_result_lost(3, $item->id, $data);
          }

          $data['result_data'] = $data_arr;


        $html = view('rm_report.pdf_num_district')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }

      if($request->btnsubmit == 'pdf_num_district_year'){
         $data['page_title'] = 'জেলা ভিত্তিক রাজস্ব মামলার বার্ষিক রিপোর্ট'; //exit;

         // Validation
         $request->validate(
          ['division' => 'required','year' => 'required',],
          ['division.required' => 'বিভাগ নির্বাচন করুন','year.required' => 'সাল নির্বাচন করুন',]
          );

         $data['year'] = $request->year;
         $data['month'] = $request->month;

         // Get Division
         $data['district_list'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
         // dd($request->division);->count()

          foreach ($data['district_list'] as $item) {
            $data_arr[$item->id]['running'] = $this->case_count_status_by_district(1, $item->id, $data);
            $data_arr[$item->id]['appeal'] = $this->case_count_status_by_district(2, $item->id, $data);
            $data_arr[$item->id]['closed'] = $this->case_count_status_by_district(3, $item->id, $data);
            $data_arr[$item->id]['win'] = $this->case_count_status_by_district_result_win(3, $item->id, $data);
            $data_arr[$item->id]['lost'] = $this->case_count_status_by_district_result_lost(3, $item->id, $data);
          }

          $data['result_data'] = $data_arr;


        $html = view('rm_report.pdf_num_district')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }

      if($request->btnsubmit == 'pdf_num_district_month'){
         $data['page_title'] = 'জেলা ভিত্তিক রাজস্ব মামলার মাসিক রিপোর্ট'; //exit;

         // Validation
         $request->validate(
          ['division' => 'required','year' => 'required',
          'month' => 'required',],
          ['division.required' => 'বিভাগ নির্বাচন করুন','year.required' => 'সাল নির্বাচন করুন',
          'month.required' => 'মাস নির্বাচন করুন',]
          );

         $data['year'] = $request->year;
         $data['month'] = $request->month;

         // Get Division
         $data['district_list'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
         // dd($request->division);->count()

          foreach ($data['district_list'] as $item) {
            $data_arr[$item->id]['running'] = $this->case_count_status_by_district(1, $item->id, $data);
            $data_arr[$item->id]['appeal'] = $this->case_count_status_by_district(2, $item->id, $data);
            $data_arr[$item->id]['closed'] = $this->case_count_status_by_district(3, $item->id, $data);
            $data_arr[$item->id]['win'] = $this->case_count_status_by_district_result_win(3, $item->id, $data);
            $data_arr[$item->id]['lost'] = $this->case_count_status_by_district_result_lost(3, $item->id, $data);
          }

          $data['result_data'] = $data_arr;


        $html = view('rm_report.pdf_num_district')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }

      // Upazila
      if($request->btnsubmit == 'pdf_num_upazila'){
         $data['page_title'] = 'উপজেলা ভিত্তিক রাজস্ব মামলার রিপোর্ট'; //exit;
         // dd($request->division);

         $request->validate([
          'division' => 'required',
          'district' => 'required'
          ],
          [
          'division.required' => 'বিভাগ নির্বাচন করুন',
          'district.required' => 'জেলা নির্বাচন করুন'
          ]);
          $data['year'] = $request->year;
          $data['month'] = $request->month;
         // Get Division
         $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();

         foreach ($data['upazilas'] as $key => $value) {
          $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_upazila($value->id);
          $data['results'][$key]['running'] = $this->case_count_status_by_upazila(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_upazila(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_upazila(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_upazila_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_upazila_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data);

        $html = view('rm_report.pdf_num_upazila')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }
      if($request->btnsubmit == 'pdf_num_upazila_year'){
         $data['page_title'] = 'উপজেলা ভিত্তিক রাজস্ব মামলার বার্ষিক রিপোর্ট'; //exit;
         // dd($request->division);

         $request->validate([
          'division' => 'required',
          'district' => 'required',
          'year' => 'required',
          ],
          [
          'division.required' => 'বিভাগ নির্বাচন করুন',
          'district.required' => 'জেলা নির্বাচন করুন',
          'year.required' => 'সাল নির্বাচন করুন',
          ]);
          $data['year'] = $request->year;
          $data['month'] = $request->month;
         // Get Division
         $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $request->district)->get();

         foreach ($data['upazilas'] as $key => $value) {
          $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_upazila($value->id);
          $data['results'][$key]['running'] = $this->case_count_status_by_upazila(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_upazila(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_upazila(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_upazila_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_upazila_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data);

        $html = view('rm_report.pdf_num_upazila')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }
      if($request->btnsubmit == 'pdf_num_upazila_month'){
         $data['page_title'] = 'উপজেলা ভিত্তিক রাজস্ব মামলার মাসিক রিপোর্ট'; //exit;
         // dd($request->division);

         $request->validate([
          'division' => 'required',
          'district' => 'required',
          'year' => 'required',
          'month' => 'required',
          ],
          [
          'division.required' => 'বিভাগ নির্বাচন করুন',
          'district.required' => 'জেলা নির্বাচন করুন',
          'year.required' => 'সাল নির্বাচন করুন',
          'month.required' => 'মাস নির্বাচন করুন',
          ]);
          $data['year'] = $request->year;
          $data['month'] = $request->month;

         // Get Division
         $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $request->district)->get();

         foreach ($data['upazilas'] as $key => $value) {
          $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
          $data['results'][$key]['id'] = $value->id;
          // $data['results'][$key]['num'] = $this->case_count_by_upazila($value->id);
          $data['results'][$key]['running'] = $this->case_count_status_by_upazila(1, $value->id, $data);
          $data['results'][$key]['appeal'] = $this->case_count_status_by_upazila(2, $value->id, $data);
          $data['results'][$key]['closed'] = $this->case_count_status_by_upazila(3, $value->id, $data);
          $data['results'][$key]['win'] = $this->case_count_status_by_upazila_result_win(3, $value->id, $data);
          $data['results'][$key]['lost'] = $this->case_count_status_by_upazila_result_lost(3, $value->id, $data);
        }
         // $data['result_data'];
         // dd($data);

        $html = view('rm_report.pdf_num_upazila')->with($data);
         // Generate PDF
        $this->generatePDF($html);
      }
    }

    public function case_count_by_division($id, $data){
      // dd($data);

      $query = DB::table('case_register')
      ->where('division_id', $id);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      // $query->count();

      return $query;
    }

    public function case_count_by_district($id){
      return DB::table('case_register')->where('district_id', $id)->count();
    }

    public function case_count_by_upazila($id){
      return DB::table('case_register')->where('upazila_id', $id)->count();
    }

    public function case_count_by_court($id){
      return DB::table('case_register')->where('court_id', $id)->count();
    }

    public function case_count_by_court_status($courtID, $status, $data){
      $query = DB::table('case_register')->where('court_id', $courtID)->where('status', $status);
      if(!empty($data['court_name'])){
        // dd($data['court_name']);
        $query->where('court_id', $data['court_name']);
      }
      return $query->count();
    }

    public function case_count_status_by_district($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('district_id', $id)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }

    public function case_count_status_by_upazila($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('upazila_id', $id)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    public function case_count_status_by_division($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('division_id', $id)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    public function case_count_status_by_division_result_win($status, $id, $data){
      // dd($status);
      $query = DB::table('r_m__case_rgisters')->where('division_id', $id)->where('in_favour_govt', 1)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    public function case_count_status_by_division_result_lost($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('division_id', $id)->where('in_favour_govt', 0)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }




    public function case_count_status_by_district_result_win($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('district_id', $id)->where('in_favour_govt', 1)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    public function case_count_status_by_district_result_lost($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('district_id', $id)->where('in_favour_govt', 0)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }




    public function case_count_status_by_upazila_result_win($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('upazila_id', $id)->where('in_favour_govt', 1)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    public function case_count_status_by_upazila_result_lost($status, $id, $data){
      // dd($data);
      $query = DB::table('r_m__case_rgisters')->where('upazila_id', $id)->where('in_favour_govt', 0)->where('status', $status);
      if($data['year']){
        $query->whereYear('case_date', '=', $data['year']);
      }

      if($data['month']){
        $query->whereMonth('case_date', $data['month']);
      }
      return $query->count();
      // return $query;
    }


    /*public function case_count_by_court_status($courtID, $status){
      return DB::table('case_register')->where('court_id', $courtID)->where('status', $status)->count();
    }*/

    public function case_courtwise($divisionID){
      /*$query = DB::table('case_register')
      ->select('case_register.id', 'case_register.case_number', 'case_register.case_date', 'case_register.court_id', 'case_register.district_id', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'court.court_name')
      ->join('court', 'case_register.court_id', '=', 'court.id')
      ->join('district', 'case_register.district_id', '=', 'district.id')
      ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
      ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
      // ->where('court_id', $id)
      ->orderBy('case_register.id','DESC')
      ->groupBy('case_register.district_id', 'case_register.court_id');
      $result = $query->get(); case_register.status,
        */

          $query = DB::table('case_register')
          ->select('court.court_name', 'district.district_name_bn', DB::raw('count(*) as case_count, case_register.court_id'),  DB::raw('count(case_register.status) as status_count'))
          ->join('court', 'case_register.court_id', '=', 'court.id')
          ->join('district', 'case_register.district_id', '=', 'district.id')
                 // ->where('status', '<>', 1)
          ->groupBy('case_register.court_id')
          ->groupBy('case_register.status');
          $query->get();
          $result = $query->toSql();

       /*$users = User::where(function ($query) {
        $query->select('type')
            ->from('membership')
            ->whereColumn('membership.user_id', 'users.id')
            ->orderByDesc('membership.start_date')
            ->limit(1);
          }, 'Pro')->get();*/


      dd($result);
      // return $result;
    }

    public function case_list_by_court(){
      /*$query = DB::table('case_register')
      ->select('case_register.id', 'case_register.case_number', 'case_register.case_date', 'case_register.court_id', 'case_register.district_id', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'court.court_name')
      ->join('court', 'case_register.court_id', '=', 'court.id')
      ->join('district', 'case_register.district_id', '=', 'district.id')
      ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
      ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
      // ->where('court_id', $id)
      ->orderBy('case_register.id','DESC')
      ->groupBy('case_register.district_id', 'case_register.court_id');
      $result = $query->get();
    */

      $query = DB::table('case_register')
      ->select('court.court_name', 'district.district_name_bn', DB::raw('count(*) as case_count, case_register.status, case_register.court_id'))
      ->join('court', 'case_register.court_id', '=', 'court.id')
      ->join('district', 'case_register.district_id', '=', 'district.id')
             // ->where('status', '<>', 1)
      ->groupBy('case_register.status', 'case_register.court_id');
      $query->get();
      $result = $query->toSql();
      // dd($result);
      return $result;
    }

    public function case_list_filter($data){
      // Convert DB date formate
      $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
      $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

      // Query
      $query = DB::table('r_m__case_rgisters')
      ->select('r_m__case_rgisters.id', 'r_m__case_rgisters.case_no', 'r_m__case_rgisters.case_date', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'r_m__case_rgisters.case_date')
      ->join('district', 'r_m__case_rgisters.district_id', '=', 'district.id')
      ->join('upazila', 'r_m__case_rgisters.upazila_id', '=', 'upazila.id')
      ->join('mouja', 'r_m__case_rgisters.mouja_id', '=', 'mouja.id')
      ->orderBy('id','DESC');
      // ->where('r_m__case_rgisters.id', '=', 29);
      if($dateFrom != NULL && $dateTo != NULL){
       $query->whereBetween('r_m__case_rgisters.case_date', [$dateFrom, $dateTo]);
     }
     if(!empty($data['division'])){
       $query->where('r_m__case_rgisters.division_id', $data['division']);
     }
     if(!empty($data['district'])){
       $query->where('r_m__case_rgisters.district_id', $data['district']);
     }
     $result = $query->get();
      // $result = $query->toSql();
      // dd($result);
     return $result;
   }

   public function case_list_role_filter($data){
    $result = array();
    // dd($data);
      // Convert DB date formate
      // $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
      // $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

      // Query
      $query = DB::table('case_register')
      ->select('case_register.id', 'case_register.case_number', 'case_register.case_date', 'mouja.mouja_name_bn', 'role.role_name', 'district.district_name_bn', 'upazila.upazila_name_bn', 'case_register.case_date')
      ->leftJoin('district', 'case_register.district_id', '=', 'district.id')
      ->leftJoin('upazila', 'case_register.upazila_id', '=', 'upazila.id')
      ->leftJoin('mouja', 'case_register.mouja_id', '=', 'mouja.id')
      ->leftJoin('role', 'case_register.action_user_group_id', '=', 'role.id')
      ->orderBy('id','DESC')
      ->where('case_register.action_user_group_id', $data['role'])
      ->where('case_register.division_id', $data['division']);
       $query->where('case_register.district_id', $data['district']);
      // dd($data['upazila']);
      if (!empty($data['upazila'])) {
        // $query->where('case_register.upazila_id', $data['upazila']);
      }
     $result = $query->get();
     // dd($result);

     if(count($result) > 0){
         return $result;
     }else{
        return false;
     }

     // $st = isset($result) ? $result : false;
    // if ($st){
        //now you can use it safely.
      // return $result;
    // }else{
      // return false;
    // }


     /*if(!empty($result))
     {*/
     /* $result = $query->toSql();
      dd($result);*/

      // return $result;
     /*}else{
      return false;
     }*/
   }

   public function generatePDF($html){
    $mpdf = new \Mpdf\Mpdf([
     'default_font_size' => 12,
     'default_font'      => 'kalpurush'
     ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      // dd($request->all());
    if($request->btnsubmit == 'pdf_division'){
         $data['page_title'] = 'বিভাগ ভিত্তিক রাজস্ব মামলার রিপোর্ট'; //exit;
         $html = view('rm_report.pdf_division')->with($data);
         // echo 'hello';

         $mpdf = new \Mpdf\Mpdf([
          'default_font_size' => 12,
          'default_font'      => 'kalpurush'
          ]);
         $mpdf->WriteHTML($html);
         $mpdf->Output();
       }

     }




   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
   */
   public function index()
   {
      //
   }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
      //
   }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      //
   }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      //
   }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      //
   }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      //
   }


}
