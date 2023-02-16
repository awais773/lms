<?php

namespace App\Http\Controllers\api;
use App\Models\Cource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Cource = Cource::latest()->with('user')->get();
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Cource,
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
        $Cource = new Cource();
        $Cource->name = $req->name;
        $Cource->user_id = $req->user_id;
        $Cource->details = $req->details;
        // $Cource->time = $req->time;
        $Cource->save();

        if ($files = $req->file('image')) {
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'societyPicture/';
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
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Society created successfully',
            'data' => $Cource,
        ]);
    }


   
    public function show($id)
    {
        $Cource = Cource::with('user')->where('id',$id)->first();
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Cource,
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
        $Cource = Cource::find($id);
        $Cource->name = $request->name;
        $Cource->details = $request->details;
        $Cource->user_id = $request->user_id;
        $Cource->update();
        return response()->json([
            'success' => true,
            'message' => 'Cource updated successfully.',
            'data' => $Cource,

        ]);
    }

   
    public function destroy($id)
    {
        $Cource = Cource::find($id);
        if (!empty($Cource)) {
            $Cource->delete();
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
