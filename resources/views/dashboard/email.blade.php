@extends('dashboard')

@section('title')
{{$email->email}} | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		envelope
	@endslot
	@slot('headerTitle')
		Configure Email
	@endslot
	@slot('content')
		<h4><i class="fa fa-envelope"></i> {{$email->email}}</h4>
		<div class="panel-wrap">
			<ul class="panel-buttons">
				<li><a href="#basic">Basic Tasks</a></li><li><a href="#forward">Forward</a></li><li><a href="#autorespond">Autoresponder</a></li>
				<span class="highlighter"></span>
			</ul>
			<div class="panels">
				<div id="basic" class="panel">
					<div class="row clearfix">
						<div class="4u 6u(narrow) 12u(mobile)">
							{!! Form::open(['route' => ['email-delete',$email->id],'id' => 'emp-delete'])!!}
								<button>Delete Mailbox</button>
							{!! Form::close() !!}
							<p class="note"><em>Deleting mailboxes is non-ireversible and cannot be restored. Use this with caution!</em></p>
						</div>
						<div class="4u 6u(narrow) 12u(mobile)">
							<h5>Change Password</h5>
							{!! Form::open(['route' => ['email-update',$email->id],'id' => 'emp-update']) !!}
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
								<button>Update Password</button>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<div id="forward" class="panel">
					<div class="row clearfix">
						<div class="8u  12u(narrow)">
							<p>Incoming mail to <b>{{$email->email}}</b></p>
							<p>Delivers to the following</p>
							<ul>
								@foreach($forwards as $forward)
								<li>{{$forward->forward}}
									@if($forward->forward != $email->email)
									{!! Form::open(['route' => ['forward-delete',$forward->id],'id' => 'forward-delete'])!!}
										<button><i class="fa fa-times"></i></button>
									{!! Form::close() !!}
									@endif
								</li>
								@endforeach
							</ul>
						</div>
						<div class="8u 12u(narrow)">
							<h5>Add Forward Email</h5>
							{!! Form::open(['route' => ['forward-update',$email->id],'id' => 'forward-update']) !!}
								<div>
								{!! Form::label('forward','Deliver mail to an additional address:') !!}
								{!! Form::text('forward','',['placeholder' => 'Internal or External Email Address']) !!}
								@if ($errors->has('forward'))
					                <span class="error">
					                    <strong>{{ $errors->first('forward') }}</strong>
					                </span>
					            @endif
					            </div>
								
								<button>Add</button>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<div id="autorespond" class="panel">
					<div class="row clearfix">
						<div class="8u 12u(narrow)">
							<h5>Add Autorespond Message</h5>
							<p class="note"><em>Sets up an automatic response to be sent when a message is received.</em></p>
							{!! Form::model($email,['route' => ['respond-update',$email->id],'id' => 'respond-update']) !!}
								<div>
								{!! Form::textarea('auto_respond',old('auto_respond'),['placeholder' => 'Autorespond Message','rows' =>'5']) !!}
								@if ($errors->has('auto_respond'))
					                <span class="error">
					                    <strong>{{ $errors->first('auto_respond') }}</strong>
					                </span>
					            @endif
					            </div>
								<button>Save</button>
								@if($email->auto_respond)
								<button id="respond-disable-button">Disable</button>
								@endif
							{!! Form::close() !!}
							
							{!! Form::open(['route' => ['respond-delete',$email->id],'id' => 'respond-delete', 'style' => 'display:none;']) !!}
							{!! Form::close() !!}
							
						</div>
					</div>
				</div>
			</div>
		</div>
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	$('.panel-buttons li:first-child').addClass('current');
	$('.panel').hide();
	$('.panel:first-child').show();
	$('.highlighter').css({width:''+$('.panel-buttons li.current').outerWidth()+'px'});
	$('.panel-buttons li a').click(function(e){
		$('.panel-buttons li').removeClass('current');
		$(this).parent().addClass('current');
		var hash = this.hash.substr(1);
		$('.panel').hide();
		$('#'+hash).show();
		return false;
	});

	$('.panel-buttons li a').hover(function(){
		$('.highlighter').css({left:''+$(this).position().left+'px'});
		$('.highlighter').css({width:''+$(this).outerWidth()+'px'});
	},function(){
		$('.highlighter').css({left:''+$('.panel-buttons li.current').position().left+'px'});
		$('.highlighter').css({width:''+$('.panel-buttons li.current').outerWidth()+'px'});
	});

	$('#emp-delete button').click(function(e){
		e.preventDefault();
		if(confirm("Are you sure you want to delete this mailbox?")){
  			$(this).parent().submit();
  		}
	});

	$('#forward-delete button').click(function(e){
		e.preventDefault();
		if(confirm("Are you sure you want to delete this forward address?")){
  			$(this).parent().submit();
  		}
	});

	$('#respond-disable-button').click(function(e){
		e.preventDefault();
		$('#respond-delete').submit();
		return false;
	});
});
@endsection