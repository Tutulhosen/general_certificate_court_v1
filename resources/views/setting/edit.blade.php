@extends('layouts.default')

@section('content')

<!-- Content Header (Page header) -->
{{-- <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Setting</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Setting</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div> --}}
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h1">অ্যাপস সেটিংস</h1>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <div class="card-body">
                                    <form action="{{ route('app.setting.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{-- @include('includes.errors') --}}
                                        <div class="form-group border-bottom">
                                            <h2>Site Info</h2>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Site Name</label>
                                            <input type="name" name="name" value="{{ $setting->name }}" class="form-control" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label for="logo">Site Logo</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="site_logo" class="custom-file-input" id="logo">
                                                        <label class="custom-file-label" for="logo">Choose file</label>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <div style="max-width: 100px; max-height: 100px;overflow:hidden; margin-left: auto">
                                                        <img src="{{ asset($setting->site_logo) }}" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label for="logo">Fevicon</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="fevicon" class="custom-file-input" id="logo">
                                                        <label class="custom-file-label" for="logo">Choose file</label>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <div style="max-width: 100px; max-height: 100px;overflow:hidden; margin-left: auto">
                                                        <img src="{{ asset($setting->fevicon) }}" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Site Description ( & Footer top content) </label>
                                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">{{ $setting->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta">Meta Description</label>
                                            <textarea name="meta" id="meta" rows="3" class="form-control" placeholder="Enter meta">{{ $setting->meta }}</textarea>
                                        </div>


                                        <div class="form-group border-bottom mt-5">
                                            <h4>Social Info</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="facebook" name="facebook" value="{{ $setting->facebook }}" class="form-control" placeholder="facebook url">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="twitter" name="twitter" value="{{ $setting->twitter }}" class="form-control" placeholder="twitter url">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="instagram" name="instagram" value="{{ $setting->instagram }}" class="form-control" placeholder="instagram url">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="reddit">Reddit</label>
                                                    <input type="reddit" name="reddit" value="{{ $setting->reddit }}" class="form-control" placeholder="reddit url">
                                                </div>
                                            </div>

                                        </div>
                                        {{-- <div class="form-group border-bottom mt-5">
                                            <h4>Contact Info</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" value="{{ $setting->email }}" class="form-control" placeholder="email url">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email">Phone Number</label>
                                                    <input type="text" name="phone" value="{{ $setting->phone }}" class="form-control" placeholder="phone number">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="faxno">Fax Number</label>
                                                    <input type="text" name="faxno" value="{{ $setting->faxno }}" class="form-control" placeholder="fax number">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="whatsappno">Whatsapp Number</label>
                                                    <input type="text" name="whatsappno" value="{{ $setting->whatsappno }}" class="form-control" placeholder="whatsapp number">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control" rows="1" placeholder="enter address">{{ $setting->address}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="glocation">Google Location</label>
                                                    <textarea name="glocation" id="glocation" rows="3" class="form-control" placeholder="Enter glocation">{{ $setting->glocation }}</textarea>
                                                </div>
                                            </div>
                                        </div> --}}



                                        <div class="form-group border-bottom mt-5">
                                            <h4>App Info</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="apple_app">Apple App Link</label>
                                                    <input type="text" name="apple_app" value="{{ $setting->apple_app }}" class="form-control" placeholder="Apple app link..">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="google_app">Andraid App Link</label>
                                                    <input type="text" name="google_app" value="{{ $setting->google_app }}" class="form-control" placeholder="Andraid app link">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group border-bottom mt-5">
                                            <h4>Footer Info</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <label for="footer_logo">Footer Logo</label>
                                                <div class="custom-file">
                                                    <input type="file" name="footer_logo" class="custom-file-input" id="logo">
                                                    <label class="custom-file-label" for="logo">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="col-4 text-right">
                                                <div style="max-width: 100px; max-height: 100px;overflow:hidden; margin-left: auto">
                                                    <img src="{{ asset($setting->footer_logo) }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="copyright">Copyright</label>
                                                    <input type="copyright" name="copyright" value="{{ $setting->copyright }}" class="form-control" placeholder="copyright">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-md btn-primary">Update Setting</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Card-->
{{-- <div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-label"> কেস রেজিস্টার </h3>
      </div>
      <div class="card-toolbar">
         <a href="#" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>New Record
         </a>
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      <table class="table table-hover mb-6">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">নাম</th>
               <th scope="col">ইউজারনেম</th>
               <th scope="col">ইউজার রোল</th>
               <th scope="col">অফিসের নাম</th>
               <th scope="col">ইমেইল এড্রেস</th>
               <th scope="col">স্ট্যাটাস</th>
               <th scope="col">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <th scope="row">1</th>
               <td>a</td>
               <td>s</td>
               <td>s</td>
               <td>s</td>
               <td>s</td>
               <td>
                  <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
               </td>
               <td>
                  <a href="#" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">View</a>
                  <a href="#" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">Edit</a>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div> --}}
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


