@extends('layouts.default')

@section('content')
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title" style="display: flex; justify-content: space-between; width: 100%">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                        <form action="{{ route('appeal.generateAppeal.pdf') }}" method="post">
                            @csrf
                            <div>
                                <button type="submit" class="btn btn-danger btn-link">Export</button>
                                <input type="hidden" name="page_title" value="{{ $page_title }}">
                            </div>
                        </form>
                    </div>
                </div>
            @if (Auth::user()->role_id==28)
                <div class="btn btn-primary" style="width:17%; margin-left:25px">
                    <a style="color: white" href="{{route('appeal.old.dismiss.case.entry.from')}}">পুরাতন নিষ্পত্তিকৃত মামলা এন্ট্রি</a>
                </div>
            @endif
                

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
             @if(Session::has('withError'))
             <div class="alert alert-danger text-center">
                {{ Session::get('withError') }}
             </div>

             @endif
                
            
            <div class="card-body overflow-auto">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
    
                @include('appeal.search')
                @php
                    $today = date('Y-m-d', strtotime(now()));
                    $today_time = date('H:i:s', strtotime(now()));
                @endphp
                <table class="table table-hover mb-6 font-size-h5">
                    <thead class="thead-customStyle2 font-size-h6">
                        <tr style="text-align: justify">
                            <th scope="col">ক্রমিক নং</th>
                            {{-- <th scope="col">ক্রমিক নং</th> --}}
                            {{-- <th scope="col" style="">সার্টিফিকেট অবস্থা</th> --}}
                            <th scope="col">মামলা নম্বর</th>
                            
                            <th scope="col">আবেদনের তারিখ</th>
                            <th scope="col">আবেদনকারী</th>
                            <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                            <th scope="col">সর্বশেষ আদেশ এর তারিখ</th>
                            <th scope="col">পদক্ষেপ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $key => $row)                      
                        <tr>
                                <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                                
                                <td>{{ $row->case_no }}</td>
                                <td>{{ en2bn($row->appeal_date) }}</td>
                                <td>{{ $row->org_name }}</td>
                                <td>@php
                                    if (isset($row->court_id)) {
                                        echo DB::table('court')
                                            ->where('id', $row->court_id)
                                            ->first()->court_name;
                                    }
                                @endphp</td>
                                <td>{{ en2bn($row->last_order_date) }}</td>
    
                                <td>
                                    <div class="btn-group float-right">
                                        <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.old.dismiss.case.details', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div class="d-flex justify-content-center">
                    {!! $results->links() !!}
                </div>
            </div>

            </div>
        </div>
  
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @include('appealTrial.inc._script')
@endsection
<script>
    function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
    // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
    }
</script>