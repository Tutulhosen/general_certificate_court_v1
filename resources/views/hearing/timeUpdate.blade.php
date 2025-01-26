@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2  ">{{ $page_title }}</h3>
            </div>
        </div>
            
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
                <table class="table table-hover mb-6 font-size-h5">
                    <thead class="thead-customStyle2 font-size-h6">
                        <tr>
                            <th scope="col" width="30">#</th>
                            <th scope="col">মামলা নম্বর</th>
                            <th scope="col">আবেদনকারীর নাম</th>
                            <th scope="col">শুনানির তারিখ</th>
                            <th scope="col">শুনানির সময়</th>
                            <th scope="col" colspan="2" class="text-center">শুনানির পরিবর্তিত সময় </th>
                            <!-- <th scope="col" width="70">অ্যাকশন</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $key => $row)
                            @php
                                $bela = '';
                                if(!empty($row->next_date_trial_time)){
                                    if(date('a', strtotime($row->next_date_trial_time)) == 'am'){
                                        $bela = "সকাল";
                                    }else{
                                        $bela = "বিকাল";
                                    }
                                }
                            @endphp
                            <input type="hidden" name="appeal_id" value="{{ $row->id }}">
                            <tr>
                                <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                                
                                <td>{{ en2bn($row->case_no) }}</td>
                                <td>
                                    {{ $row->caseCreator->name ?? ''}}
                                </td>
                                <td>{{ en2bn($row->next_date) }}</td>
                                <td id="showTrialTime_{{ $row->id }}">
                                    {{ $bela }} {{ en2bn(date('h:i', strtotime($row->next_date_trial_time))) }} 
                                </td>
                                <td>
                                    <input class="form-control  form-control-md" type="time" name="trialTime" id="trialTime_{{ $row->id }}"  id="example-time-input">
                                </td>
                                <td>
                                    <button class="btn btn-primary timeUpdate" data-rowid="{{ $row->id }}">সংরক্ষণ</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
        <!--end::Card-->
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <script type="text/javascript">
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
                        $('form#trialTimeChange').submit();
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

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->


    <script>
        
        $('.timeUpdate').on('click',function(e){
            e.preventDefault();

            var time=$('#trialTime_'+($(this).data('rowid'))).val();
            var rowid=$(this).data('rowid');
            swal.showLoading();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('appeal.hearingTimeUpdateStore') }}',
                method: 'post',
                data: {
                    trialUpdatedTime:time,
                    appeal_id:$(this).data('rowid'),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                   Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            
                            text: response.message,
                            
                            })
                    }
                    else if(response.success == 'success')
                    {
                        
                        Swal.fire({
                            // icon: 'success',
                            text: response.message,
                            
                        });
                        // alert(response.updatedTrialTime)
                        $('#showTrialTime_'+rowid).html(response.updatedTrialTime)
                            
                    }
                }
            });

        });
        
    </script>
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
        <!--end::Page Scripts-->
    @endsection
