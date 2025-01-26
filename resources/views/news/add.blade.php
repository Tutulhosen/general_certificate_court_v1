@php
    $roleID = Auth::user()->role_id;
    $officeInfo = user_office_info();
@endphp

@extends('layouts.default')

@section('content')

<style type="text/css">
    #appRowDiv td{padding: 5px; border-color: #ccc;}
    #appRowDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
</style>
<!--begin::Row-->
<div class="row">

    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                <div class="card-toolbar">
                    <!-- <div class="example-tools justify-content-center">
                        <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                    </div> -->
                </div>
            </div>
            	@if ($errors->any())

				     @foreach ($errors->all() as $error)
				    	<li class="alert alert-danger">{{ $error }}</li>
				     @endforeach

 				@endif
            <!--begin::Form-->
            <form action="{{ route('news.store') }}" id="newsCreate" class="form" method="POST">
            @csrf
                <div class="card-body">
                    <div class="radio">
                        <label class="mr-5">
                            <input type="radio" onclick="newsHideShow(1);" class="mr-2" value="1" checked name="newsType">খবর
                        </label>
                        <label>
                            <input type="radio" onclick="newsHideShow(2);" class="mr-2" value="2" name="newsType">জনপ্রিয় সংবাদ 
                        </label>
                    </div>
                    <div class="form-group">
                        <h3 id="shortNews">খবর</h3>
                        <h3 id="bigNews" style="display: none;">জনপ্রিয় সংবাদ</h3>
                        <div class="row" id="bigNewsTitle" style="display: none;">
                            <div class="form-group col-lg-4">
                                <label for="news_title" class=" form-control-label">শিরোনাম <span class="text-danger">*</span></label>
                                <input type="text" id="news_title" name="news_title" placeholder="শিরোনাম লিখুন" class="form-control form-control-sm">
                                <span style="color: red">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="news_writer" class=" form-control-label">লেখকের নাম  <span class="text-danger">*</span></label>
                                <input type="text" id="news_writer" name="news_writer" placeholder="লেখকের নাম  লিখুন" class="form-control form-control-sm">
                                <span style="color: red">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="news_date" class=" form-control-label"> তারিখ <span class="text-danger">*</span></label>
                                <input type="text" name="news_date" id="news_date" class="form-control  common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="news_details" class=" form-control-label">বিস্তারিত খবর <span class="text-danger">*</span></label>
                                <textarea type="text" id="news_details" name="news_details" placeholder="বিস্তারিত খবর লিখুন" class="form-control form-control-sm"></textarea>
                                <span style="color: red">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>
                            <div class="col-lg-3">
                              <label>স্ট্যাটাস</label>
                                <div class="radio-inline">
                                    <label class="radio">
                                    <input type="radio" name="status" value="1" checked="checked" />
                                    <span></span>এনাবল</label>
                                    <label class="radio">
                                    <input type="radio" name="status" value="0" />
                                    <span></span>ডিসএবল</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-body-->
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-7">
                            
                            <button type="button" class="btn btn-primary mr-2" onclick="myFunction()">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>

</div>
<!--end::Row-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')

<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')

<script type="text/javascript">
      

     // common datepicker =============== start
    $('.common_datepicker').datepicker({
        format: "yyyy/mm/dd",
        todayHighlight: true,
        orientation: "bottom left"
    });
    // common datepicker =============== end  

    function newsHideShow(typeID){
        // var typeID = $('input[name="investigatorType"]').val();
        // alert(typeID);
        if(typeID == 1){
            $("#shortNews").show();
            $("#bigNews").hide();
            $("#bigNewsTitle").hide();
        } else{
            $("#shortNews").hide();
            $("#bigNews").show();
            $("#bigNewsTitle").show();
        }
        // console.log(att);
    } 
    function myFunction() {
        Swal.fire({
            title: "আপনি কি সংরক্ষণ করতে চান?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "হ্যাঁ",
            cancelButtonText: "না",
        })
        .then(function(result) {
            if (result.value) {
                // setTimeout(() => {
                $('form#newsCreate').submit();
                // }, 5000);
                KTApp.blockPage({
                    // overlayColor: '#1bc5bd',
                    overlayColor: 'black',
                    opacity: 0.2,
                    // size: 'sm',
                    message: 'Please wait...',
                    state: 'danger' // a bootstrap color
                });
                Swal.fire({
                    position: "top-right",
                    icon: "success",
                    title: "সফলভাবে সাবমিট করা হয়েছে!",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
            }
        });
    }
</script>


    @endsection


    <!--end::Page Scripts-->


