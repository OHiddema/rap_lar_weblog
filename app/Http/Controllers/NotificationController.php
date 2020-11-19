<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function show() {
        return view('notifications.contact');
    }

    public function store() {
        request()->validate(['email'=>'required|email']);

        // Mail::raw('plain text message', function ($message) {
        //     $message->to(request('email'));
        //     $message->subject('Subject');
        // });

        Mail::to(request('email'))->send(new \App\Mail\ContactMe(auth()->user()->name));

        return redirect('/contact')
        ->with('message','Email sent!');
    }
}
