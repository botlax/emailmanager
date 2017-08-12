@extends('dashboard')

@section('title')
Delete Mailbox | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		user-times
	@endslot
	@slot('headerTitle')
		Delete Mailbox
	@endslot
	@slot('content')
		<div class="row clearfix">
			<div class="8u 12u(narrower)">
				<ul id="email-list-delete">
				@foreach($emails as $email)
					<li><i class="fa fa-envelope"></i> {{$email->email}}
					{!! Form::open(['route' => ['email-delete',$email->id],'id' => 'emp-delete'])!!}
						<button><i class="fa fa-times"></i></button>
					{!! Form::close() !!}
					</li>
				@endforeach
				</ul>
			</div>
		</div>
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	$('#emp-delete button').click(function(e){
		e.preventDefault();
		if(confirm("Are you sure you want to delete this mailbox?")){
  			$(this).parent().submit();
  		}
	});
});
@endsection