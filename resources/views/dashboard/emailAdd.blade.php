@extends('dashboard')

@section('title')
Create Mailbox | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		user-plus
	@endslot
	@slot('headerTitle')
		Create Mailbox
	@endslot
	@slot('content')
		{!! Form::open(['route' => 'email-add','id' => 'emp-add','files' => true]) !!}
        <div class="email-form">
    		<div>		
			{!! Form::text('email', old('email'),['placeholder' => 'Email','id'=>'email']) !!}<span class="concat">{{'@'.\Auth::user()->username}}</span>
			@if ($errors->has('email'))
                <span class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            </div>
			<div>
			{!! Form::password('password',['placeholder' => 'Password']) !!}
			@if ($errors->has('password'))
                <span class="error">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            </div>
			<div>
			{!! Form::password('password_confirmation',['placeholder' => 'Repeat Password']) !!}
			@if ($errors->has('password_confirmation'))
                <span class="error">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
            </div>
			{!! Form::submit('Add') !!}
        </div>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	$('#email').val($('#email').val().replace('{{'@'.\Auth::user()->username}}', ''));
	$('form').submit(function(){
		if($.trim($('#email').val()) != ''){
			$('#email').val($('#email').val()+'{{'@'.\Auth::user()->username}}');
		}
	});
});
@endsection