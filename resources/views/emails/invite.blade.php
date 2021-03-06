@extends('mail')
{{-- Action Button --}}

@section('greeting')
Hi!
@endsection

@section('intro')
An email request from {{$data['company']}}
@endsection

@section('content')


<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <tr>
                    <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <p>{{$data['message']}}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>



@endsection

@section('outro')
For your action.
@endsection

@section('salutation')
Regards
@endsection