<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SednMail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\call;

class MailController extends Controller
{
    public function sendEmail(){
        try{
            $toEmailAddress = 'tityapong77@gmail.com';
            $welcomeMessage="Welcome to our website";
           $response=  Mail::to($toEmailAddress)->send(new SednMail($welcomeMessage));
           dd($response);

        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
