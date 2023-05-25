<?php

namespace App\Http\Controllers\api;
use App\Models\qualification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
   
    public function index()
    {
        $qualification = qualification::latest()->get();
        if (is_null($qualification)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $qualification,
        ]);
    }


    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            // 'thumbnail' => 'required',
            // 'video' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
    
        $qualification = new qualification();
        $qualification->name = $req->name;
        $qualification->save();
    
        if (is_null($qualification)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => ' qualification created successfully',
            'data' => $qualification,
        ], 200);
    }
    


    public function show($id)
{
    $qualification = qualification::where('id',$id)->first();

    if (is_null($qualification)) {
        return response()->json([
            'success' => false,
            'message' => 'qualification not found'
        ], 404);
    }
    return response()->json([
        'success' => true,
        'data' => $qualification,
    ], 200);
}

    public function update(Request $req, $id)
    {
        $video = qualification::find($id);
        if (is_null($video)) {
            return response()->json([
                'success' => false,
                'message' => 'course not found',
            ], 404);
        }
        $validator = Validator::make($req->all(), []);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toJson(),
            ], 400);
        }
        $video->name = $req->name;
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'qualification updated successfully',
            'data' => $video,
        ], 200);
    }

   
    public function destroy($id)
    {
        $qualification = qualification::find($id);
        if (!empty($qualification)) {
            $qualification->delete();
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
