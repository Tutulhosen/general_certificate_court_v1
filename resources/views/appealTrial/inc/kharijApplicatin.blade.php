@extends('layouts.default')
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap py-5">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                </div>

                <div class="col-2">
                    <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                </div>

              

        </div>
    </div>
</div>

<div class="card-body" id="element-to-print">
    <div id="body" style="overflow: hidden;">
        <?php echo $kharijTemplete->template_full ?>
    </div>
</div>

</div>

</div>

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
                        var opt = {
            margin:       1,
            filename:     'myfile.pdf',
            pagebreak: { avoid: ['tr', 'td'] },
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
    @endsection