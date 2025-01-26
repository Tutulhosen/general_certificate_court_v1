<p>{{$day}} {{$month_name}}, {{$year}}</p>
জনাব, <strong>{{ $name_of_receiver }}</strong>,
<p>{{$body}}</p>

@if(!empty($shortorderTemplateUrl))
@foreach($shortorderTemplateUrl as $key=>$value)
<a href="{{ $value }}" target="_blank">{{ $shortorderTemplateName[$key] }} আদেশের নথি দেখুন </a>
<br> 
@endforeach
@endif


<p>প্রেরক ,</p>
<p>{{ $user_name }}</p>
<p>{{ $user_designation }}, {{ $court_name }}</p>
<p><a href="{{ url('/') }}">স্মার্ট জেনারেল সার্টিফিকেট আদালত </a></p>