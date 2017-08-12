@extends('skel')

@section('title')
Login | Email Manager System
@endsection

@section('body-class')
login
@endsection

@section('content')
    <header>
       <h1>Email Manager System</h1>
    </header>
    <div id="login-form">
        <form class="clearfix" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
            
            <div class="form-input">
                {!! Form::label('username', 'Domain') !!}
                {!! Form::text('username') !!}
                @if ($errors->has('username'))
                    <span class="error">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div><div class="form-input">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password') !!}
                 @if ($errors->has('password'))
                    <span class="error">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div><div class="form-misc clearfix">

                 <div class="remember-wrap">
                   
                </div>

            </div>
                                  

            {!! Form::submit('Let me in.'); !!}
        </form>
    </div>
@endsection

@section('js')
    
@endsection
