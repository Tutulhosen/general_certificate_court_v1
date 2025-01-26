@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

@section('landing')
<div class="container">
	<div class="row py-5 my-5" style="margin-top:75px ">
		<div class="col-12" style="margin-top: 44px;">
			<table class="table">
				<thead>
					<tr>
						<td>#</td>
						<td>Name</td>
						<td>NID</td>
						<td>Mobile No</td>
					</tr>
				</thead>
				<tbody>
					@php
						$i=1;
					@endphp
					@foreach($nids as $key=>$row)
					<tr>
						<td>{{ $i++}}</td>
						<td>{{ $row->name_bn }}</td>
						<td>{{ $row->national_id}}</td>
						<td>{{ $row->mobile_no}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

