<?php

namespace App\Http\Controllers\api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\MailContact;
use App\Mail\MailContacts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function index()
    {
        $Contact = Contact::latest()->get();
        if (is_null($Contact)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Contact,
        ],200);
    }


    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            // 'title' => 'required|unique:dealer_add_societies',
            // 'title' => 'required|unique:dealer_add_societies,title,NULL,id,user_id,' . auth()->id(),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson()
                'message' => 'title already exist',

            ], 400);
        }
        $Contact = new Contact();
        $Contact->message = $req->message;
        $Contact->name = $req->name;
        $Contact->email = $req->email;
        $Contact->subject = $req->subject;
        $Contact->save();
        Mail::to('support@tutorsuperb.co.uk')->send(new MailContact($req->subject, $req->message));
        $email = 'Thank You';
        Mail::to($req->input('email'))->send(new MailContacts($email));
        if (is_null($Contact)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Package created successfully',
            'data' => $Contact,
        ],200);
    }
  
    public function destroy($id)
    {
        $Contact = Contact::find($id);
        if (!empty($Contact)) {
            $Contact->delete();
            return response()->json([
                'success' => true,
                'message' => ' delete successfuly',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again ',
            ]);
        }
    }
}
