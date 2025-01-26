@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

@section('content')


      
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       @dd($response);
                        {!! $response !!}
                    </div>
                </div>
            </div>
        
    
      
    @endsection
    @section('scripts')
        <script src="{{ asset('js/initiate/init.js') }}"></script>
        <script src="{{ asset('js/location/location.js') }}"></script>
        <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
        <script src="{{ asset('js/home.js') }}"></script>
        <script>
            $(document).ready(function() {
                // $('.font_u_14 tbody tr td').attr('bgcolor','green');
            });
        </script>
  
    @endsection
