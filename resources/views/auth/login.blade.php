
@php 

$redirect_url=route('home').'/login/page';
header('Location: '.$redirect_url);
die();

@endphp