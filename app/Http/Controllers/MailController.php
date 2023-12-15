<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Mail;
use App\Mail\NotifMail;
use Illuminate\Support\Facades\DB;
  
class MailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $mailData = [
            'title' => 'Mail from gondangria.com',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('kucingdiki@gmail.com')->send(new NotifMail($mailData));
           
        dd("Email is sent successfully.");
    }

    public function send_ticket($id)
    {
        $data = DB::table('pengunjungs')
            ->where(['id', $id])
            ->first();
            
        $mailData = [
            'title' => 'Mail from gondangria.com',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('kucingdiki@gmail.com')->send(new NotifMail($mailData));
           
        dd("Email is sent successfully.");
    }
}