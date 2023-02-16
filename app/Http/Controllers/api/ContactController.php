<?php

namespace App\Http\Controllers\api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        ]);
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

        if ($files = $req->file('image')) {
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'packagePicture/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $upload_path . $image_full_name);
                $image = $image_url;

                // $productImage = new SocietyPicture();
                // $productImage->image = $image;
                // $productImage->dealer_add_society_id = $Cource->id;
                // $productImage->save();
            }

            //    $fltnos  = $req->input('add_society_id');
            //     foreach($fltnos as $key => $fltno) {
            //         $modelName = new PlotSize();
            //         $modelName->add_society_id = $fltno;
            //         $modelName->dealer_add_socity_id = $rating->id;
            //         $modelName->save();
            //     }

        }
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
        ]);
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
