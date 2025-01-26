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
            <form action="{{ route('case-status.update', $case_status->id) }}" class="form" method="POST">
            @csrf
                  <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <div class="form-group col-lg-6">
                                <label for="status_name" class=" form-control-label">স্ট্যাটাসের নাম <span class="text-danger">*</span></label>
                                <input type="text" id="status_name" name="status_name" placeholder="স্ট্যাটাসের নাম লিখুন" class="form-control form-control-sm" value="{{ $case_status->status_name}}">
                                <span style="color: red">
                                      {{ $errors->first('name') }}
                                </span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="templete" class=" form-control-label">মন্তব্যের টেমপ্লেট <span class="text-danger">*</span></label>
                                <textarea type="text" id="templete" name="templete" rows="10" placeholder="মন্তব্যের টেমপ্লেট লিখুন" class="form-control form-control-sm" value="{{ $case_status->status_templete}}">{{ $case_status->status_templete}}</textarea>
                                <span style="color: red">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <table class="table table-hover mb-6 font-size-h6" >
                                <thead class="thead-light">
                                   <tr>
                                      <!-- <th scope="col" width="30">#</th> -->
                                       <th scope="col" >
                                        সিলেক্ট করুণ
                                     </th>
                                      <th scope="col">ইউজার রোল নাম</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   @foreach ($roles as $row)
                                   
                                  <tr>
                                     <td>
                                        <div class="checkbox-inline">
                                            
                                            @php
                                            $mk = array_map('intval', explode(',', $case_status->role_access));
                                            @endphp
                                           <label class="checkbox"> 
                                           <input type="checkbox" name="role_id[]"  value="{{ $row->id }}" {{ in_array($row->id, $mk) ? 'checked': '' }} /><span></span>
                                        </div>
                                     </td>
                                      <td>{{ $row->role_name }}</td>
                                     
                                   </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                     </div>
                  </div> <!--end::Card-body-->

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-7">
                            <button type="submit" class="btn btn-primary mr-2" onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
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
     

   
    <!--end::Page Scripts-->


