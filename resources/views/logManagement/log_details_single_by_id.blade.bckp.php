@php
//dd($log_details_single_by_id);
if(!empty($log_details_single_by_id->applicant))
{

    $applicant = json_decode($log_details_single_by_id->applicant);
}
else {
    $applicant=null;
}
if(!empty($log_details_single_by_id->victim))
{

    $victim = json_decode($log_details_single_by_id->victim);
}
else {
    $victim=null;
}
if(!empty($log_details_single_by_id->defaulter))
{

    $defaulter = json_decode($log_details_single_by_id->defaulter);
}
else {
    $defaulter=null;
}
if(!empty($log_details_single_by_id->witness))
{

    $witness = json_decode($log_details_single_by_id->witness);
}
else {
    $witness=null;
}
if(!empty($log_details_single_by_id->lawyer))
{

    $lawyer = json_decode($log_details_single_by_id->lawyer);
}
else {
    $lawyer=null;
}

if(!empty($log_details_single_by_id->defaulter_witness))
{

    $defaulter_witness = json_decode($log_details_single_by_id->defaulter_witness);
}
else {
    $defaulter_witness=null;
}

if(!empty($log_details_single_by_id->defaulter_lawyer ))
{

    $defaulter_lawyer  = json_decode($log_details_single_by_id->defaulter_lawyer );
}
else {
    $defaulter_lawyer =null;
}

//$victim = json_decode($log_details_single_by_id->victim);
//$defaulter = json_decode($log_details_single_by_id->defaulter);

//$witness=json_decode($log_details_single_by_id->witness);
$case_date_from_created=explode(' ',$log_details_single_by_id->created_at)[0];

if($log_details_single_by_id->case_basic_info)
{
    $case_basic_info=json_decode($log_details_single_by_id->case_basic_info);
    $division=DB::table('division')->where('id','=',$case_basic_info->division)->first();
    $district=DB::table('district')->where('id','=',$case_basic_info->district)->first();
    $upazila=DB::table('upazila')->where('id','=',$case_basic_info->upazila)->first();
}
else {
    $case_basic_info=null;
    $division=null;
    $district=null;
    $upazila=null;
}



$files=json_decode($log_details_single_by_id->files);


//dd($defaulter);
@endphp

@extends('layouts.default')

@section('content')
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg .tg-nluh {
            background-color: #dae8fc;
            border-color: #cbcefb;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-19u4 {
            background-color: #ecf4ff;
            border-color: #cbcefb;
            font-weight: bold;
            text-align: right;
            vertical-align: top
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row" id="element-to-print">

                <div class="col-md-12">
                    @if(!empty($applicant ))
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row">ক্রম</th>
                                <th scope="row">নাম</th>
                                <th scope="row">লিঙ্গ</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">মাতার নাম</th>
                                <th scope="row">জাতীয় পরিচয়পত্র</th>
                                <th scope="row">মোবাইল নম্বর</th>
                                <th scope="row">ইমেইল</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                if (!isset($applicant->gender)) {
                                    $gender=' - ';
                                } else {
                                    if ($applicant->gender == 'MALE') {
                                        $gender='পুরুষ';
                                    } else {
                                        $gender='মেয়ে';
                                    }
                                }
                                
                            @endphp

                            <tr>
                                <td>{{ en2bn('1') }}.</td>
                                <td>{{ $applicant->name ?? '-' }}</td>
                                <td>{{ $gender }}</td>
                                <td>{{ $applicant->father ?? '-' }}</td>
                                <td>{{ $applicant->mother ?? '-' }}</td>
                                <td>{{ $applicant->nid ?? '-' }}</td>
                                <td>{{ $applicant->phn ?? '-' }}</td>
                                <td>{{ $applicant->email ?? '-' }}</td>
                                <td>{{ $applicant->presentAddress ?? '-' }}</td>
                            </tr>

                        </tbody>
                    </table>
                    @endif
                    <br>
                    @if (!empty($victim->name))
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">ভিক্টিমের বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row">ক্রম</th>
                                    <th scope="row">নাম</th>
                                    <th scope="row">লিঙ্গ</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">মাতার নাম</th>
                                    <th scope="row">জাতীয় পরিচয়পত্র</th>
                                    <th scope="row">মোবাইল নম্বর</th>
                                    <th scope="row">ইমেইল</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    if (!isset($victim->gender)) {
                                        $victimgender=' - ';
                                    } else {
                                        if ($victim->gender == 'MALE') {
                                            $victimgender='পুরুষ';
                                        } else {
                                            $victimgender='মেয়ে';
                                        }
                                    }
                                    
                                @endphp

                                <tr>
                                    <td>{{ en2bn('1') }}.</td>
                                    <td>{{ $victim->name ?? '-' }}</td>
                                    <td>{{ $victimgender }}</td>
                                    <td>{{ $victim->father ?? '-' }}</td>
                                    <td>{{ $victim->mother ?? '-' }}</td>
                                    <td>{{ $victim->nid ?? '-' }}</td>
                                    <td>{{ $victim->phn ?? '-' }}</td>
                                    <td>{{ $victim->email ?? '-' }}</td>
                                    <td>{{ $victim->presentAddress ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    @endif
                    <br>
                    @if (!empty($defaulter))
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বিবাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row">ক্রম</th>
                                <th scope="row">নাম</th>
                                <th scope="row">লিঙ্গ</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">মাতার নাম</th>
                                <th scope="row">জাতীয় পরিচয়পত্র</th>
                                <th scope="row">মোবাইল নম্বর</th>
                                <th scope="row">ইমেইল</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($defaulter as $defaulterpeople)
                                @php
                                    if (!isset($defaulterpeople->gender)) {
                                        $defaulterpeoplegender=' - ';
                                    } else {
                                        if ($defaulterpeople->gender == 'MALE') {
                                            $defaulterpeoplegender='পুরুষ';
                                        } else {
                                            $defaulterpeoplegender='মেয়ে';
                                        }
                                    }
                                    
                                @endphp

                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $defaulterpeople->name ?? '-' }}</td>
                                    <td>{{ $defaulterpeoplegender }}</td>
                                    <td>{{ $defaulterpeople->father ?? '-' }}</td>
                                    <td>{{ $defaulterpeople->mother ?? '-' }}</td>
                                    <td>{{ $defaulterpeople->nid ?? '-' }}</td>
                                    <td>{{ $defaulterpeople->phn ?? '-' }}</td>
                                    <td>{{ $defaulterpeople->email ?? '-' }}</td>
                                    <td>{{ $defaulterpeople->presentAddress ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach

                        </tbody>
                    </table>
                     <br>
                     @if (!empty($witness))
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">সাক্ষীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row">ক্রম</th>
                                <th scope="row">নাম</th>
                                <th scope="row">লিঙ্গ</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">মাতার নাম</th>
                                <th scope="row">জাতীয় পরিচয়পত্র</th>
                                <th scope="row">মোবাইল নম্বর</th>
                                <th scope="row">ইমেইল</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($witness as $witnesspeople)
                                @php
                                    if (!isset($witnesspeople->gender)) {
                                        $witnesspeoplegender=' - ';
                                    } else {
                                        if ($witnesspeople->gender == 'MALE') {
                                            $witnesspeoplegender='পুরুষ';
                                        } else {
                                            $witnesspeoplegender='মেয়ে';
                                        }
                                    }
                                    
                                @endphp

                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $witnesspeople->name ?? '-' }}</td>
                                    <td>{{ $witnesspeoplegender }}</td>
                                    <td>{{ $witnesspeople->father ?? '-' }}</td>
                                    <td>{{ $witnesspeople->mother ?? '-' }}</td>
                                    <td>{{ $witnesspeople->nid ?? '-' }}</td>
                                    <td>{{ $witnesspeople->phn ?? '-' }}</td>
                                    <td>{{ $witnesspeople->email ?? '-' }}</td>
                                    <td>{{ $witnesspeople->presentAddress ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <br>
                    @endif
                 </div>
                 @if(!empty($case_basic_info))
                <div class="col-md-12">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">ঘটনার তারিখ সময় ও স্থান </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>বিগত ইং {{ en2bn($case_basic_info->caseDate) }} তারিখ মোতাবেক বাংলা
                                    {{ BnSal($log_details_single_by_id->created_at, 'Asia/Dhaka', 'j F Y') }} সময়:
                                    @if (date('a', strtotime($log_details_single_by_id->created_at)) == 'pm')
                                        বিকাল
                                    @else
                                        সকাল
                                    @endif

                                    {{ en2bn(date('h:i:s', strtotime($log_details_single_by_id->created_at))) }}
                                    । {{ $division->division_name_bn ?? '-' }} বিভাগের
                                    {{ $district->district_name_bn ?? '-' }} জেলার
                                    {{ $upazila->upazila_name_bn ?? '-' }} উপজেলায়।
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">ঘটনার বিবরণ</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                    {{ str_replace('&nbsp;', '', strip_tags($case_basic_info->case_details)) }}
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
                 @endif
                @if (!empty($lawyer))
                    <div class="col-md-12">

                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="5">আইনজীবীর বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>

                                    <th scope="row">ক্রম</th>
                                    <th scope="row">নাম</th>
                                    <th scope="row">লিঙ্গ</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">মাতার নাম</th>
                                    <th scope="row">জাতীয় পরিচয়পত্র</th>
                                    <th scope="row">পদবী</th>
                                    <th scope="row">প্রতিষ্ঠানের নাম</th>
                                    <th scope="row">প্রতিষ্ঠানের আইডি</th>
                                    <th scope="row">মোবাইল নম্বর</th>
                                    <th scope="row">ইমেইল</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @php
                                    if (!isset($lawyer->gender)) {
                                        $lawyergender=' - ';
                                    } else {
                                        if ($lawyer->gender == 'MALE') {
                                            $lawyergender='পুরুষ';
                                        } else {
                                            $lawyergender='মেয়ে';
                                        }
                                    }
                                    
                                @endphp
                                    <td>{{ en2bn('1') }}.</td>
                                    <td>{{ $lawyer->name ?? '-' }}</td>
                                    <td>{{ $lawyergender  }}</td>
                                    <td>{{ $lawyer->father ?? '-' }}</td>
                                    <td>{{ $lawyer->mother ?? '-' }}</td>
                                    <td>{{ $lawyer->nid ?? '-' }}</td>
                                    <td>{{ $lawyer->designation ?? '-' }}</td>
                                    <td>{{ $lawyer->organization ?? '-' }}</td>
                                    <td>{{ $lawyer->organization_id ?? '-' }}</td>
                                    <td>{{ $lawyer->phn ?? '-' }}</td>
                                    <td>{{ $lawyer->email ?? '-' }}</td>
                                    <td>{{ $lawyer->presentAddress ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                @endif
                <br>

                @if (!empty($defaulter_witness))
               <table class="table table-striped border">
                   <thead>
                       <th class="h3" scope="col" colspan="4">বিবাদী পক্ষের সাক্ষীর বিবরণ</th>
                   </thead>
                   <thead>
                       <tr>
                           <th scope="row">ক্রম</th>
                           <th scope="row">নাম</th>
                           <th scope="row">লিঙ্গ</th>
                           <th scope="row">পিতা/স্বামীর নাম</th>
                           <th scope="row">মাতার নাম</th>
                           <th scope="row">জাতীয় পরিচয়পত্র</th>
                           <th scope="row">মোবাইল নম্বর</th>
                           <th scope="row">ইমেইল</th>
                           <th scope="row">ঠিকানা</th>
                       </tr>
                   </thead>
                   <tbody>
                       @php $k = 1; @endphp
                       @foreach ($defaulter_witness as $witnesspeople)
                           @php
                               if (!isset($witnesspeople->gender)) {
                                   $witnesspeoplegender=' - ';
                               } else {
                                   if ($witnesspeople->gender == 'MALE') {
                                       $witnesspeoplegender='পুরুষ';
                                   } else {
                                       $witnesspeoplegender='মেয়ে';
                                   }
                               }
                               
                           @endphp

                           <tr>
                               <td>{{ en2bn($k) }}.</td>
                               <td>{{ $witnesspeople->name ?? '-' }}</td>
                               <td>{{ $witnesspeoplegender }}</td>
                               <td>{{ $witnesspeople->father ?? '-' }}</td>
                               <td>{{ $witnesspeople->mother ?? '-' }}</td>
                               <td>{{ $witnesspeople->nid ?? '-' }}</td>
                               <td>{{ $witnesspeople->phn ?? '-' }}</td>
                               <td>{{ $witnesspeople->email ?? '-' }}</td>
                               <td>{{ $witnesspeople->presentAddress ?? '-' }}</td>
                           </tr>
                           @php $k++; @endphp
                       @endforeach
                   </tbody>
               </table>
                @endif  
                <br>
                @if (!empty($defaulter_lawyer))
               <table class="table table-striped border">
                   <thead>
                       <th class="h3" scope="col" colspan="4">বিবাদী পক্ষের আইনজীবী বিবরণ</th>
                   </thead>
                   <thead>
                       <tr>
                           <th scope="row">ক্রম</th>
                           <th scope="row">নাম</th>
                           <th scope="row">লিঙ্গ</th>
                           <th scope="row">পিতা/স্বামীর নাম</th>
                           <th scope="row">মাতার নাম</th>
                           <th scope="row">জাতীয় পরিচয়পত্র</th>
                           <th scope="row">মোবাইল নম্বর</th>
                           <th scope="row">ইমেইল</th>
                           <th scope="row">ঠিকানা</th>
                       </tr>
                   </thead>
                   <tbody>
                       @php $k = 1; @endphp
                       @foreach ($defaulter_lawyer as $witnesspeople)
                           @php
                               if (!isset($witnesspeople->gender)) {
                                   $witnesspeoplegender=' - ';
                               } else {
                                   if ($witnesspeople->gender == 'MALE') {
                                       $witnesspeoplegender='পুরুষ';
                                   } else {
                                       $witnesspeoplegender='মেয়ে';
                                   }
                               }
                               
                           @endphp

                           <tr>
                               <td>{{ en2bn($k) }}.</td>
                               <td>{{ $witnesspeople->name ?? '-' }}</td>
                               <td>{{ $witnesspeoplegender }}</td>
                               <td>{{ $witnesspeople->father ?? '-' }}</td>
                               <td>{{ $witnesspeople->mother ?? '-' }}</td>
                               <td>{{ $witnesspeople->nid ?? '-' }}</td>
                               <td>{{ $witnesspeople->phn ?? '-' }}</td>
                               <td>{{ $witnesspeople->email ?? '-' }}</td>
                               <td>{{ $witnesspeople->presentAddress ?? '-' }}</td>
                           </tr>
                           @php $k++; @endphp
                       @endforeach
                   </tbody>
               </table>
                @endif  



            </div> 
                    <br>
                    @if(empty($files))
                    <div class="pt-5">
                        <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি</p>
                    </div>
                    @else

                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                        </thead>
                       <tbody>
                          <tr>
                             <td>
                                @foreach ($files as $key => $row)
                                    
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                  <button class="btn bg-success-o-75" type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                              </div>
                                             
                                              <input readonly type="text" class="form-control" value="{{ $row->file_category ?? '' }}" />
                                              <div class="input-group-append">
                                                  <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left">
                                                      <i class="fa fas fa-file-pdf"></i>
                                                      <b>দেখুন</b>
                                                     
                                                   </a>
                                                  
                                              </div>
                                              
                                          </div>
                                         </div>
                                         <br>

                                @endforeach
                             </td>
                          </tr>
                       </tbody>
                    </table> 
                    @endif


                </div>
                <!--end::Card-->
            @endsection

            @section('scripts')
                {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
                    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                    function generatePDF() {
                        var element = document.getElementById('element-to-print');
                        html2pdf(element);
                    }
                </script>
            @endsection

            {{-- Includable CSS Related Page --}}
            @section('styles')
                <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
                    type="text/css" />
                <!--end::Page Vendors Styles-->
            @endsection

            {{-- Scripts Section Related Page --}}
            @section('scripts')
                <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
                <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
                <!--end::Page Scripts-->
            @endsection
