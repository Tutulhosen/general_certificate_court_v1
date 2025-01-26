@extends('layouts.default')

@php 
if(isset($_GET['division']))
{
    $selected_division=$_GET['division'];
}
else {
    $selected_division=' ';
}
if(isset($_GET['district']))
{
    $selected_district=$_GET['district'];
}
else {
    $selected_district=' ';
}
if(isset($_GET['upazila']))
{
    $selected_upazila=$_GET['upazila'];
}
else {
    $selected_upazila=' ';
}
@endphp

@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    অফিস নির্বাচন করুন
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div style="display: none">
                <p>অফিস সিস্টেমে লোড করুন</p>
                <div class="btn-group">
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="2">বিভাগ</a>
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="3">জেলা</a>
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="4">উপজেলা</a>
                </div>
            </div>

     

            <fieldset class="mb-6">
                <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                <form action="{{ route('admin.doptor.management.import.offices.search') }}" method="get">

                    <div class="form-group row">
                        <div class="col-lg-3 mb-5">
                            <select name="division" class="form-control form-control-sm" id="division_id">
                                <option value="">-বিভাগ নির্বাচন করুন-</option>
                                @foreach ($divisions as $value)
                                    <option value="{{ $value->id }}" @if ($selected_division == $value->id) selected @endif>
                                        {{ $value->division_name_bng }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="district" id="district_id" class="form-control form-control-sm">
                                <option value="">-জেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                <option value="">-উপজেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2 search">অনুসন্ধান
                                করুন</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-light font-size-h6">
                    <tr>
                        <th scope="col" width="30">#</th>

                        <th scope="col">বিভাগ</th>
                        <th scope="col">জেলা</th>
                        <th scope="col">উপজেলা</th>
                        <th scope="col">অফিস</th>
                        <th scope="col" width="70">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($all_office_bangladesh as $row)
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn(++$i) }}.</td>
                            <td>{{ $row->division_name_bng }}</td>
                            <td>{{ $row->district_name_bng }}</td>
                            <td>{{ $row->upazila_name_bng }}</td>
                            <td>{{ $row->office_name_bng }}</td>
                            <td><a class="btn btn-primary "
                                href="{{ route('admin.doptor.management.user_list.segmented.all', [
                                     'office_id' => encrypt($row->office_id) 
                                     ]
                                ) }}">প্রবেশ</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center pt-5">
                {{ $all_office_bangladesh->appends(request()->input())->links() }}
            </div </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(Session::has('withError'))
        <script>
            Swal.fire(
            'তথ্য পাওয়া যায় নাই'
            )
        </script>
       @endif

        @if( request()->get('district') )
           <script>
           var disID = {{ request()->get('district') }};
         </script>
         @else
         <script>
            var disID = 0;
          </script>
        @endif
        @if( request()->get('upazila') )
        <script>var upID = {{  request()->get('upazila')}};</script>
        @else
        <script>
            var upID = 0;
        </script>
       @endif


        <script type="text/javascript">
            jQuery(document).ready(function() {
                

                jQuery('select[name="division"]').on('change', function() {

                    var dataID = jQuery(this).val();

                    jQuery("#district_id").after('<div class="loadersmall"></div>');

                    if (dataID) {
                        jQuery.ajax({
                            url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentdistrict/' +
                                dataID,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                jQuery('select[name="district"]').html(
                                    '<div class="loadersmall"></div>');

                                jQuery('select[name="district"]').html(
                                    '<option value="">-- জেলা নির্বাচন করুন --</option>');
                                jQuery.each(data, function(key, value) {
                                    jQuery('select[name="district"]').append(
                                        '<option value="' + key +
                                        '">' + value + '</option>');
                                });
                                jQuery('.loadersmall').remove();
                            }
                        });
                    } else {
                        $('select[name="district"]').empty();
                    }
                });



                // Dependable Upazila List
                jQuery('select[name="district"]').on('change', function() {
                    var dataID = jQuery(this).val();

                    jQuery("#upazila_id").after('<div class="loadersmall"></div>');

                    if (dataID) {
                        jQuery.ajax({
                            url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentupazila/' +
                                dataID,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                jQuery('select[name="upazila"]').html(
                                    '<div class="loadersmall"></div>');

                                jQuery('select[name="upazila"]').html(
                                    '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                                jQuery.each(data, function(key, value) {
                                    jQuery('select[name="upazila"]').append(
                                        '<option value="' + key +
                                        '">' + value + '</option>');
                                });
                                jQuery('.loadersmall').remove();
                            }
                        });
                    } else {
                        $('select[name="upazila"]').empty();
                    }
                });


                var divID = $('#division_id').find(":selected").val();
                
                
        
                

                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (divID !=' ') {
                    jQuery.ajax({
                        url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentdistrict/' +
                            divID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="district"]').html(
                                '<option value="">-- জেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                if (disID == key) {
                                    var selected = 'selected';
                                } else {
                                    var selected = ' ';
                                }
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key +
                                    '"' + selected + '>' + value + '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }



                if (typeof disID !== "undefined") {
                    jQuery.ajax({
                        url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentupazila/' +
                        disID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="upazila"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="upazila"]').html(
                                '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                if (upID == key) {
                                    var selected = 'selected';
                                } else {
                                    var selected = ' ';
                                }
                                jQuery('select[name="upazila"]').append(
                                    '<option value="' + key +
                                    '"' + selected + '>' + value + '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });

                } else {
                    $('select[name="upazila"]').empty();
                }



            })
        </script>


        <script>
            $('.load_office').on('click', function(e) {
                e.preventDefault();
                var lavel = $(this).data('lavel');

                var formdata = new FormData();

                swal.showLoading();

                $.ajax({
                    url: '{{ route('admin.doptor.management.import.offices') }}',
                    method: 'post',
                    data: {
                        office_lavel: lavel,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.success == 'error') {
                            Swal.fire({
                                icon: 'error',
                                text: response.message,

                            })
                        } else if (response.success == 'success') {

                            Swal.fire({
                                icon: 'success',
                                text: response.message,

                            })
                        }
                        location.reload();
                    }
                });

            })
        </script>
    @endsection
