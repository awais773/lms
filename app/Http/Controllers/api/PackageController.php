<?php

namespace App\Http\Controllers\api;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{

    public function index()
    {
        $Package = Package::latest()->with('user')->get();
        if (is_null($Package)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Package,
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
        $Package = new Package();
        $Package->charges_pay = $req->charges_pay;
        // $Package->review = $req->review;
        $Package->user_id = $req->user_id;
        $Package->demo = $req->demo;
        $Package->discount = $req->discount;
        $Package->online = $req->online;
        $Package->offline = $req->offline;
        $Package->save();

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
        if (is_null($Package)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Package created successfully',
            'data' => $Package,
        ]);
    }

    public function show($id)
    {
        $Package = Package::with('user')->where('id', $id)->first();
        if (is_null($Package)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Package,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Package = Package::find($id);
        $Package->charges_pay = $request->charges_pay;
        $Package->demo = $request->demo;
        $Package->discount = $request->discount;
        $Package->online = $request->online;
        $Package->offline = $request->offline;
        $Package->user_id = $request->user_id;
        // $Package->review = $request->review;
        $Package->update();
        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully.',
            'data' => $Package,
        ]);
    }

    public function destroy($id)
    {
        $Package = Package::find($id);
        if (!empty($Package)) {
            $Package->delete();
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
