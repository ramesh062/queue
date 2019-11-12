<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function sendEmail(Request $request)
    {
        $data=[
            'subject'=>'demo for send email by job',
            'message'=>'queue and job demo for send email.'
        ];

        EmailJob::dispatch($data);

        // EmailJob::dispatch($data)
        // ->delay(now()->addMinutes(2));
        return redirect('home');

    }
}
