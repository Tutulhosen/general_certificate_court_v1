@php
   $user = Auth::user();
   $roleID = Auth::user()->role_id;
   $badi='ধারকের বিবরণ';
   $bibadi='খাতকের বিবরণ';
   
@endphp

@extends('layouts.default')

@section('content')

<style type="text/css">
   .tg {border-collapse:collapse;border-spacing:0;width: 100%;}
   .tg td{border-color:black;border-style:solid;border-width:1px;font-size:14px;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg th{border-color:black;border-style:solid;border-width:1px;font-size:14px;font-weight:normal;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg .tg-nluh{background-color:#dae8fc;border-color:#cbcefb;text-align:left;vertical-align:top}
   .tg .tg-19u4{background-color:#ecf4ff;border-color:#cbcefb;font-weight:bold;text-align:right;vertical-align:top}
</style>



    
     <style type="text/css">
        #myiframe {
            width: 100%;
            height: 900px;
        }
         h2{
            
            text-align: center;
            background-color: green;
            height: 53px;
            width: 40%;
            border: 2px solid white;
            padding-top: 12px;
            color: white;
            border-radius: 10px;
            margin-bottom: 10px !important;
            margin-top: 20px !important;
        }
    </style>
                <div class="col-md-12 py-5">
                    <table class="table table-striped border">
                        @foreach ($attachmentList as $key => $row)
                        
                                <h2 style="widows: 50%; margin:auto; text-align:center; background-color:green">{{ $row->file_category ?? '' }}</h2>
                                {{-- <embed src="" width="800px" height="2100px" /> --}}
                                <iframe name="myiframe" id="myiframe" src="{{ asset($row->file_path . $row->file_headline) }}"></iframe>
                            
                        @endforeach
                        
                        <br><br>
                        
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

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function generatePDF() {
        
        var element = document.getElementById('element-to-print');
    
        var opt = {
            margin: 1,
            filename: 'myfile.pdf',
            pagebreak: {
                avoid: ['tr', 'td']
            },
            image: {
                type: 'pdf',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
    }
</script>
<!--end::Page Scripts-->
@endsection



