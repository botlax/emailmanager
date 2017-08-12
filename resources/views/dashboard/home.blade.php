@extends('dashboard')

@section('title')
Emails | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		home
	@endslot
	@slot('headerTitle')
		Emails
	@endslot
	@slot('content')
		<div class="row clearfix">
			<div class="8u 12u(narrower)">
				<ul id="email-list">
				@foreach($emails as $email)
					<li><a href="{{url('email/'.$email->id)}}"><i class="fa fa-envelope"></i> {{$email->email}}</a></li>
				@endforeach
				</ul>
			</div>
		</div>
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	
});
@endsection