<?php

namespace App\Http\Controllers;

use App\Emails;
use App\User;
use App\Forward;
use Auth;
use App\Mail\EmailEntry;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.emailAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'password' => ['required','confirmed','min:6','regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X]).*$/'],
            'email' => ['required','email',Rule::unique('emails','email')->ignore(auth()->id())]
        ],[
            'password.regex' => 'Your new password must contain a lower case letter, upper case letter and a digit'
        ]);

        $email = New Emails($request->except('password_confirmation'));

        Auth::user()->email()->save($email);


        $email->forwards()->save(Forward::create(['forward' => $request->only('email')['email']]));

        $data['message'] = 'Add email '.$email->email.' with password "'.$email->password.'"';
        $data['company'] = Auth::user()->company;
        Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
        flash('Email successfully added! Your mailbox will be ready within 24 hours.')->success()->important();
        return redirect('/');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $email = $user->email()->findOrFail($id);
        $forwards = $email->forwards()->orderBy('forward','ASC')->get();
        return view('dashboard.email',compact('email','forwards'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $emails = Auth::user()->email()->orderBy('email','ASC')->get();
        return view('dashboard.delete',compact('emails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'password' => ['required','confirmed','min:6','regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X]).*$/']
        ],[
            'password.regex' => 'Your new password must contain a lower case letter, upper case letter and a digit'
        ]);

        $email = Emails::findOrFail($id);

        $email->password = $request->input('password');
        $email->save();
        $data['message'] = 'change password to '.$email->password.' for email "'.$email->email;
        $data['company'] = Auth::user()->company;
        Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
        flash('Password successfully updated! Your changes will take effect within 24 hours.')->success()->important();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function forwardUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'forward' => 'required|email'
        ]);

        $email = Emails::findOrFail($id);
        $email->forwards()->save(New Forward($request->all()));

        $data['message'] = 'Add forward '.$request->all()['forward'].' for email "'.$email->email;
        $data['company'] = Auth::user()->company;
        Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
        flash('Forward email successfully added! Your changes will take effect within 24 hours.')->success()->important();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function respondUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'auto_respond' => 'required'
        ]);

        $email = Emails::findOrFail($id);
        $email->auto_respond = $request->input('auto_respond');
        $email->save();

        $data['message'] = 'Add response '.$request->input('auto_respond').' for email "'.$email->email;
        $data['company'] = Auth::user()->company;
        Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
        flash('Autoresponse successfully added! Your changes will take effect within 24 hours.')->success()->important();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $email = Emails::findOrFail($id);
        $email->forwards()->delete();

        $email_add = $email->email;

        if(Emails::destroy($id)){
            $data['message'] = 'delete email '.$email_add;
            $data['company'] = Auth::user()->company;
            Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
            flash('Email successfully deleted!')->success();
            return redirect('/');
        }
        else{
            flash('An error has occurred. Please refresh the page and try again.')->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function forwardDestroy($id)
    {
        $forward = Forward::findOrFail($id);
        $email = $forward->emails()->first()->email;
        $forward = $forward->forward;
        if(Forward::destroy($id)){
            $data['message'] = 'Delete forward '.$forward.' for email "'.$email;
            $data['company'] = Auth::user()->company;
            Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
            flash('Forward email successfully deleted! Your changes will take effect within 24 hours.')->success()->important();
            return redirect()->back();
        }
        else{
            flash('An error has occurred. Please refresh the page and try again.')->error();
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function respondDestroy($id)
    {
        $email = Emails::findOrFail($id);
        $email->auto_respond = null;
        $email->save();
        $data['message'] = 'Delete response for email '.$email->email;
        $data['company'] = Auth::user()->company;
        Mail::to('lacsinapaul@gmail.com')->send(new EmailEntry($data));
        flash('Autoresponse successfully deleted! Your changes will take effect within 24 hours.')->success()->important();
        return redirect()->back();
    }
}
