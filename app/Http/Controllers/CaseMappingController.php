<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseMappingController extends Controller
{
    public function index()
    {

        //$roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $available_court = DB::table('court')->where('division_id', $officeInfo->division_id)->where('district_id', $officeInfo->district_id)->get();
        $upazila = DB::table('upazila')->where('division_id', $officeInfo->division_id)->where('district_id', $officeInfo->district_id)->get();
        //  $assignedupzilla = DB::table('case_mapping')->where('court_id', $id)->where('district_id', $officeInfo->district_id)->where('status', 1)->select('upazilla_id')->get();

        $data['available_court'] = $available_court;
        $data['upzillas'] = $upazila;
        $data['page_title'] = 'কেস ম্যাপিং';
        return view('case_mapping.index')->with($data);
    }
    public function store(Request $request)
    {
        //$upzilla_case_mapping = $request->upzilla_case_mapping;
        //$court_id = $request->court_id;

        $officeInfo = user_office_info();
        $assignedupzilla = DB::table('case_mapping')->where('court_id', $request->court_id)->where('district_id', $officeInfo->district_id)->where('status', 1)->select('upazilla_id')->get();
        $assignedipzilla = array();

        foreach ($assignedupzilla as $assignedupzilla) {
            array_push($assignedipzilla, $assignedupzilla->upazilla_id);
        }

        $requestupzill = array();
        if (!empty($request->upzilla_case_mapping)) {

            foreach ($request->upzilla_case_mapping as $up_id) {
                array_push($requestupzill, $up_id);

                if (!in_array($up_id, $assignedipzilla)) {

                    $active_court = DB::table('case_mapping')->select('court_id')->where('district_id', $officeInfo->district_id)->where('upazilla_id', $up_id)->where('status', 1)->first();

                    $upname = DB::table('upazila')->select('upazila_name_bn')->where('id', $up_id)->first();
                    if ($active_court) {
                        $active_court = DB::table('court')->where('id', $active_court->court_id)->first();

                        return response()->json([
                            'status' => 'error',
                            'upname'=>$upname->upazila_name_bn,
                            'active_court'=>$active_court->court_name

                        ]);
                    }

                    DB::table('case_mapping')->insert([
                        'court_id' => $request->court_id,
                        'district_id' => $officeInfo->district_id,
                        'upazilla_id' => $up_id,
                        'status' => 1,
                    ]);
                    $new_court_id = $request->court_id;

                    $case_id=DB::table('gcc_appeals')->where('upazila_id',$up_id)->where('district_id',$officeInfo->district_id)
                    ->select('id')->get();
                    // dd($case_id);
                    if(!empty($case_id))
                    {
                         foreach($case_id as $value)
                         {

                        DB::table('gcc_appeals')
                        ->where('id',$value->id)
                        ->update(
                            array(
                            'court_id' =>$new_court_id,
                            ));
                         }       
                    }

                }

            }
        }

        //var_dump($assignedipzilla);
        //var_dump($requestupzill);

        foreach ($assignedipzilla as $up_id) {

            if (!in_array($up_id, $requestupzill)) {

                DB::table('case_mapping')->where('upazilla_id', $up_id)
                    ->where('court_id', $request->court_id)
                    ->where('district_id', $officeInfo->district_id)
                    ->update(array('status' => 0));

                //echo $up_id;

            }
            $previous_court_id=DB::table('gcc_appeals')->where('upazila_id',$up_id)->where('district_id',$officeInfo->district_id)
                ->select('court_id')->get();
                if(!empty($previous_court_id))
                {
            //dd($previous_court_id);
                    foreach($previous_court_id as $value)
                         {

                      DB::table('gcc_appeals')->where('upazila_id', $up_id)
                     ->where('district_id',$officeInfo->district_id)
                     ->update(
                        array(
                        'court_id' =>NULL,
                        'previous_court_id'=>$value->court_id
                        ));
                         }
                        
                
                }

            
        }

        return response()->json([
            'status' => 'success',

        ]);
    }

    public function show_court(Request $request)
    {

        //var_dump($request->id);

        $officeInfo = user_office_info();
        $assignedupzilla = DB::table('case_mapping')->where('court_id', $request->id)->where('district_id', $officeInfo->district_id)->where('status', 1)->select('upazilla_id')->get();

        $assignedupzillas = [];
        foreach ($assignedupzilla as $assignedupzilla) {
            array_push($assignedupzillas, $assignedupzilla->upazilla_id);
        }
        $upazila = DB::table('upazila')->where('division_id', $officeInfo->division_id)->where('district_id', $officeInfo->district_id)->get();

        $html = ' ';
        $html .= '<table class="table table-hover mb-6 font-size-h6">
        <thead class="thead-light">
            <tr>
                <!-- <th scope="col" width="30">#</th> -->
                <th scope="col">
                    সিলেক্ট করুণ
                </th>
                <th scope="col">উপজেলার নাম</th>

            </tr>
        </thead>
        <tbody>';

        foreach ($upazila as $upzilla) {

            $checked = in_array($upzilla->id, $assignedupzillas) ? 'checked' : '';
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<div class="checkbox-inline">';
            $html .= '<label class="checkbox">';
            $html .= '<label class="checkbox">';
            $html .= '<input type="checkbox" name="upzilla_case_mapping[]"
                                value="' . $upzilla->id . '" class="check_upzilla" ' . $checked . '/><span></span>';
            $html .= '</div>
                </td>
                <td>' . $upzilla->upazila_name_bn . '</td>';

            $html .= '<tr>';
        }
        $html .= '</tbody>
                </table>';
        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }
}
