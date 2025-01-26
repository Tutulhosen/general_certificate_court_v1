@extends('layouts.default')


@section('content')
    <fieldset class="pb-5 " data-wizard-type="step-content">
        <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
            <div class="d-flex align-items-center mr-2 py-2">
                <h3 class="mb-0 mr-8">আদেশ নামা সংযুক্তি (যদি থাকে)</h3>
            </div>
            <!--end::Info-->

        </div>

        <br>

        <!-- Template -->
        <!-- <div id="template" > -->
        @if ($runningcommandList)
            <div class="card">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="100" scope="col" class="align-middle"> ১ - নম্বর :</th>
                                    <th scope="col" class="align-middle">আদেশ নামা</th>
                                    <th width="100">
                                        @php
                                            $filePath = $runningcommandList->file_path . $runningcommandList->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('appeal.adeshnama.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="onama_file_type" class="form-control form-control-sm"
                            id="file_name_important" placeholder="আদেশ নামা">
                    </div>

                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_customFile" onChange="runningAttachmentTitle()"
                                        id="order_customFile" style="display: none;" name="onama_file_name">
                                    <label class=" custom-file-label order_customFilealamin" for="order_customFile">ফাইল
                                        নির্বাচন
                                        করুন</label>
                                </div>
                            </div>
                        </div>
                        {{-- @dd($data) --}}
                        <div class="col-md-3 mt-1 text-center">
                            <button type="submit" class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <!-- </div> -->
        <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
            <div class="d-flex align-items-center mr-2 py-2">
                <h3 class="mb-0 mr-8">আদেশের টেমপ্লেট সংযুক্তি (যদি থাকে)</h3>
            </div>
        </div>
        <br>
        <!-- <div id="template" > -->

        {{-- 1 order --}}
        @php
            $exits1 = false;
            $file1 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '1') {
                    $exits1 = true;
                    $file1 = $templete;
                }
            }
        @endphp
        @if (!$exits1)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        {{-- <input type="hidden" name="data" id="data" value='{"status": "SEND_TO_ADM", "extra_value": "ANOTHER_VALUE"}'> --}}
                        <input type="hidden" name="orderId" id="orderId" value="1">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_1" value='রাজকীয় প্রাপ্যের সার্টিফিকেট'
                            id="file_name_order_templateFile_1" value='রাজকীয় প্রাপ্যের সার্টিফিকেট'
                            placeholder="রাজকীয় প্রাপ্যের সার্টিফিকেট">
                        {{-- <input type="text" name="order_file_type[]" class="form-control form-control-sm"
           id="file_name_order_templateFile_1" value='{"name": "রাজকীয় প্রাপ্যের সার্টিফিকেট", "id": "1"}' id="file_name_order_templateFile_1" value='রাজকীয় প্রাপ্যের সার্টিফিকেট'
           placeholder="রাজকীয় প্রাপ্যের সার্টিফিকেট"> --}}
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">

                                    <input type="file" id="order_templateFile_1" onChange="orderTemplateFile(1)"
                                        id="order_templateFile_1" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_1" for="order_templateFile_1">ফাইল
                                        নির্বাচন
                                        করুন</label>
                                </div>

                                <!-- <button type="button"
                                                                                                                                                                                                                                                                                                                                   class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">১ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file1->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file1->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align: right">
                                        @php
                                            $filePath = $file1->file_path . $file1->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2 Order --}}
        @php
            $exits2 = false;
            $file2 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '2') {
                    $exits2 = true;
                    $file2 = $templete;
                }
            }
        @endphp
        @if (!$exits2)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="2">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_2" value="৭ ধারার নোটিশ" placeholder="৭ ধারার নোটিশ">

                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_2" onChange="orderTemplateFile(2)"
                                        id="order_templateFile_2" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_2" for="order_templateFile_2">ফাইল
                                        নির্বাচন
                                        করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৩ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file2->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file2->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file2->file_path . $file2->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        {{-- 3 Order --}}
        @php
            $exits3 = false;
            $file3 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '3') {
                    $exits3 = true;
                    $file3 = $templete;
                }
            }
        @endphp
        @if (!$exits3)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="3">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_3" value="১০ (ক) ধারার নোটিশ"
                            placeholder="১০ (ক) ধারার নোটিশ">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">

                                    <input type="file" id="order_templateFile_3" onChange="orderTemplateFile(3)"
                                        id="order_templateFile_3" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_3" for="order_templateFile_3">ফাইল
                                        নির্বাচন
                                        করুন</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">২ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file3->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file3->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file3->file_path . $file3->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- 4 Order --}}
        @php
            $exits4 = false;
            $file4 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '4') {
                    $exits4 = true;
                    $file4 = $templete;
                }
            }
        @endphp

        @if (!$exits4)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="4">

                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_4" value="৭৭ বিধি কারন দর্শানোর নোটিশ"
                            placeholder="৭৭ বিধি কারন দর্শানোর নোটিশ">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_4" onChange="orderTemplateFile(4)"
                                        id="order_templateFile_4" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_4" for="order_templateFile_4">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">4 - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file4->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file4->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file4->file_path . $file4->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        {{-- 5 order --}}
        @php
            $exits5 = false;
            $file5 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '5') {
                    $exits5 = true;
                    $file5 = $templete;
                }
            }
        @endphp
        @if (!$exits5)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="5">

                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_5" value="২৯ ধারার গ্রেফতারী পরোয়ানা"
                            placeholder="২৯ ধারার গ্রেফতারী পরোয়ানা">

                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_5" onChange="orderTemplateFile(5)"
                                        id="order_templateFile_5" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_5" for="order_templateFile_5">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৫ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file5->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file5->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file5->file_path . $file5->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- Order 6 --}}
        @php
            $exits6 = false;
            $file6 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '6') {
                    $exits6 = true;
                    $file6 = $templete;
                }
            }
        @endphp
        @if (!$exits6)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="6">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_6"
                            value="অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রির সম্পর্কে নোটিশ ক্রোক পরোয়ানা"
                            placeholder="অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রির সম্পর্কে নোটিশ ক্রোক পরোয়ানা">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_6" onChange="orderTemplateFile(6)"
                                        id="order_templateFile_6" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_6" for="order_templateFile_6">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৬ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file6->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file6->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file6->file_path . $file6->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif



        {{-- Order 7 --}}
        @php
            $exits7 = false;
            $file7 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '7') {
                    $exits7 = true;
                    $file7 = $templete;
                }
            }
        @endphp
        @if (!$exits7)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="7">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_7" value="ঘোষণাপত্র স্থির করবার নোটিশ"
                            placeholder="ঘোষণাপত্র স্থির করবার নোটিশ">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_7" onChange="orderTemplateFile(7)"
                                        id="order_templateFile_7" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_7" for="order_templateFile_7">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৭ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file7->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file7->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file7->file_path . $file7->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- Order 8 --}}
        @php
            $exits8 = false;
            $file8 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '8') {
                    $exits8 = true;
                    $file8 = $templete;
                }
            }
        @endphp
        @if (!$exits8)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="8">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_8" value="দখল অর্পণের আদেশ" placeholder="দখল অর্পণের আদেশ">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_8" onChange="orderTemplateFile(8)"
                                        id="order_templateFile_8" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_8" for="order_templateFile_8">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৮ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file8->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file8->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file8->file_path . $file8->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- Order 9 --}}
        @php
            $exits9 = false;
            $file9 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '9') {
                    $exits9 = true;
                    $file9 = $templete;
                }
            }
        @endphp
        @if (!$exits9)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="9">
                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_9" value="নিলাম ইস্তেহার" placeholder="নিলাম ইস্তেহার">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_9" onChange="orderTemplateFile(9)"
                                        id="order_templateFile_9" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_9" for="order_templateFile_9">ফাইল
                                        নির্বাচন করুন</label>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">৯ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file9->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file9->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file9->file_path . $file9->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        @php
            $exits10 = false;
            $file10 = null;
            foreach ($runningorderTemplate as $key => $templete) {
                if ($templete->orderId == '10') {
                    $exits10 = true;
                    $file10 = $templete;
                }
            }
        @endphp
        @if (!$exits10)
            <form action="{{ route('appeal.adeshTemplete.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="orderId" id="orderId" value="10">

                        <input type="text" name="order_file_type[]" class="form-control form-control-sm"
                            id="file_name_order_templateFile_10" value="নিলাম ইস্তেহার প্রকাশে নাজিরকে আদেশ"
                            placeholder="নিলাম ইস্তেহার প্রকাশে নাজিরকে আদেশ">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="order_templateFile_10" onChange="orderTemplateFile(10)"
                                        id="order_templateFile_10" style="display: none;" name="order_file_name[]">
                                    <label class=" custom-file-label order_templateFile_10"
                                        for="order_templateFile_10">ফাইল
                                        নির্বাচন করুন</label>
                                </div>

                                <!-- <button type="button"
                                                                                                                                                                                                                                                                                                                                                class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center"> <button type="submit"
                                class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button></div>
                    </div>
                </div>
            </form>
        @else
            <div class="card mb-3">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;" scope="col" class="align-middle">১০ - নম্বর :</th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($file10->created_at)) }}
                                    </th>
                                    <th style="width: 150px;" scope="col" class="align-middle">
                                        {{ $file10->file_category }}
                                    </th>
                                    <th style="width: 100px; text-align:right">
                                        @php
                                            $filePath = $file10->file_path . $file10->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif



        <!-- </div> -->
        <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
            <div class="d-flex align-items-center mr-2 py-2">
                <h3 class="mb-0 mr-8">হাজিরা সংযুক্তি (যদি থাকে)</h3>
            </div>
        </div>
        <br>
        @if ($attendance_list)
            <div class="card">
                <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="100" scope="col" class="align-middle"> ১ - নম্বর :</th>
                                    <th scope="col" class="align-middle">হাজিরা</th>
                                    <th scope="col" class="align-middle">
                                        {{ en2bn(date_formater_helpers_make_bd_v2($attendance_list->created_at)) }}
                                    </th>
                                    <th width="100">
                                        @php
                                            $filePath = $attendance_list->file_path . $attendance_list->file_name;
                                            $fileUrl = asset($filePath); // Adjust if using a different path
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <button id="printReport" class="btn btn-primary btn-link" type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('appeal.attendance.attachment', encrypt($id)) }}" method="POST" id="template"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="attendance_file_type" class="form-control form-control-sm"
                            id="file_name_attendance" placeholder="হাজিরা">
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-9">
                            <div class="input-group">
                                <div class="custom-file">

                                    <input type="file" id="attendance_customFile" onChange="attendancefile()"
                                        name="attendance_file_name" style="display: none;">
                                    <label class="custom-file-label attendance_customFile"
                                        for="attendance_customFile">ফাইল
                                        নির্বাচন করুন</label>
                                </div>

                                <!-- <button type="button"
                                                                                                                                                                                                                                                                                                                                                    class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                            </div>
                        </div>
                        <div class="col-md-3 mt-1 text-center">
                            <button type="submit" class="btn btn-sm btn-success font-weight-bolder">যুক্ত করুন</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <!-- </div> -->
        {{-- show all  অন্যান্য সংযুক্তি --}}
        @if (count($onnanno_running_appeal_list) > 0)
            <section style="margin-top: 30px; margin-bottom: 30px">
                <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                    <div class="d-flex align-items-center mr-2 py-2">
                        <h3 class="mb-0 mr-8">অন্যান্য সংযুক্তিসমূহ</h3>
                    </div>

                </div>

                @foreach ($onnanno_running_appeal_list as $key => $file)
                    <div class="card mb-3">
                        <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 100px;" scope="col" class="align-middle">
                                                {{ en2bn(++$key) }} -
                                                নম্বর : </th>
                                            <th style="width: 150px;" scope="col" class="align-middle">
                                                {{ $file->file_category }}
                                            </th>
                                            <th style="width: 150px;" scope="col" class="align-middle">
                                                {{ en2bn(date_formater_helpers_make_bd_v2($file->created_at)) }}
                                            </th>
                                            <th style="width: 100px; text-align:right">
                                                @php
                                                    $filePath = $file->file_path . $file->file_name;
                                                    $fileUrl = asset($filePath); // Adjust if using a different path
                                                @endphp
                                                <a href="{{ $fileUrl }}" target="_blank">
                                                    <button id="printReport" class="btn btn-primary btn-link"
                                                        type="button">
                                                        <i class="flaticon2-print"></i>
                                                        দেখুন
                                                    </button>
                                                </a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        @endif

        {{-- For onnanno songjukti --}}
        <section>
            <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                <div class="d-flex align-items-center mr-2 py-2">
                    <h3 class="mb-0 mr-8">অন্যান্য সংযুক্তি (যদি থাকে)</h3>
                </div>
                <!--end::Info-->
                <!--begin::Users-->

                <div class="symbol-group symbol-hover py-2" style="margin-right: 30px">
                    <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip" data-placement="top"
                        title="" role="button" data-original-title="Add New File">
                        <div id="addFileRow">
                            <span class="symbol-label font-weight-bold bg-success">
                                <i class="text-white fa flaticon2-plus font-size-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!--end::Users-->

            </div>
            <form action="{{ route('appeal.onnanno.attachment', encrypt($id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mt-3 px-5">
                    <table width="100%" class="border-0 px-5" id="fileDiv" style="border:1px solid #dcd8d8;">
                        <tr></tr>
                    </table>
                    <input type="hidden" id="other_attachment_count" value="1">
                </div>
                <br>

                <!-- Template -->
                <div id="template" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" data-name="file.type" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" data-name="file.name" class="custom-file-input">
                                        <label class="custom-file-label custom-input2" for="customFile2">ফাইল নির্বাচন
                                            করুন</label>
                                    </div>

                                    <button type="button"
                                        class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="addPON" style="display: none">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-right"> <button type="submit"
                            class="btn btn-sm btn-success font-weight-bolder" style="margin-right: 41px">যুক্ত
                            করুন</button>
                    </div>
                </div>
            </form>
        </section>
    </fieldset>
@endsection


@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function runningAttachmentTitle() {

            // var value = $('#customFile' + id).val();
            var value = $('#order_customFile')[0].files[0];

            const fsize = $('#order_customFile')[0].files[0].size;
            const file_size = Math.round((fsize / 1024));

            var file_extension = value['name'].split('.').pop().toLowerCase();


            if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
                Swal.fire(

                    'ফাইল ফরম্যাট PDF,docx হতে হবে ',

                )
                // $(obj).closest("tr").remove();
            }
            if (file_size > 30720) {
                Swal.fire(

                    'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',

                )
            }

            var custom_file_name = $('#file_name_important').val();

            if (custom_file_name == "") {

                Swal.fire(

                    'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',

                )
            }

            var fileName = value['name'].split('\\').pop();
            console.log(value);

            $('.order_customFilealamin').text(value['name']);
        }

        function attendancefile() {
            // var value = $('#customFile' + id).val();
            var value = $('#attendance_customFile')[0].files[0];

            const fsize = $('#attendance_customFile')[0].files[0].size;
            const file_size = Math.round((fsize / 1024));

            var file_extension = value['name'].split('.').pop().toLowerCase();
            if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
                Swal.fire(

                    'ফাইল ফরম্যাট PDF,docx হতে হবে ',

                )
                //  $(obj).closest("tr").remove();
            }
            if (file_size > 30720) {
                Swal.fire(

                    'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',

                )
                //  $(obj).closest("tr").remove();
            }

            const custom_file_name = $('#file_name_attendance').val();

            if (custom_file_name == "") {
                Swal.fire(

                    'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',
                )
                //  $(obj).closest("tr").remove();
            }

            var fileName = value['name'].split('\\').pop();
            $('.attendance_customFile').text(value['name']);
        }

        function orderTemplateFile(id) {

            // var value = $('#customFile' + id).val();
            var value = $('#order_templateFile_' + id)[0].files[0];

            const fsize = $('#order_templateFile_' + id)[0].files[0].size;
            const file_size = Math.round((fsize / 1024));

            var file_extension = value['name'].split('.').pop().toLowerCase();
            if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
                Swal.fire(

                    'ফাইল ফরম্যাট PDF,docx হতে হবে ',

                )
                //  $(obj).closest("tr").remove();
            }
            if (file_size > 30720) {
                Swal.fire(

                    'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',

                )
                //  $(obj).closest("tr").remove();
            }

            const custom_file_name = $('#file_name_order_templateFile_' + id).val();

            if (custom_file_name == "") {
                Swal.fire(

                    'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',
                )
                //  $(obj).closest("tr").remove();
            }

            var fileName = value['name'].split('\\').pop();
            $('.order_templateFile_' + id).text(value['name']);
        }
    </script>
    @include('citizenAppealInitiate.appealCreate_Js')
@endsection
