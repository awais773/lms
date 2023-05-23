<?php

namespace App\Http\Controllers\api;
use App\Models\Cource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourceController extends Controller
{
   
    public function index()
    {
        $courses = Cource::latest()->with('class:id,name','subject:id,name','teacher')->get();
        foreach ($courses as $course) {
            $course->location = json_decode($course->location); // Decode the JSON-encoded location string
        }
        if (is_null($courses)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $courses,
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
    
        $user = Auth::guard('api')->user();
        $Cource = new Cource();
        $Cource->name = $req->name;
        $Cource->user_id = $user->id;
        $Cource->details = $req->details;
        $Cource->expertise = $req->expertise;
        $Cource->class_id = $req->class_id;
        $Cource->subject_id = $req->subject_id;
        $Cource->location = json_encode($req->location); // Store location as JSON-encoded string
        $Cource->save();
    
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Add Cource created successfully',
            'data' => $Cource,
        ], 200);
    }
    


    public function show($id)
{
    $course = Cource::with('class:id,name','subject:id,name','teacher')->where('id',$id)->first();

    if (is_null($course)) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found'
        ], 404);
    }
    $course->location = json_decode($course->location); // Decode the JSON-encoded location string

    return response()->json([
        'success' => true,
        'data' => $course,
    ], 200);
}

    public function update(Request $req, $id)
    {
        $video = Cource::find($id);
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
        $video->details = $req->details;
        $video->expertise = $req->expertise;
        $video->class_id = $req->class_id;
        $video->subject_id = $req->subject_id;
        $video->location = $req->location;
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'course updated successfully',
            'data' => $video,
        ], 200);
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

    public function indexgetTeacher($user_id)
    {
        $user = User::find($user_id);
        if ($user === null) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }
        $courses = Cource::latest()->with('class:id,name','subject:id,name','teacher')->whereIn('user_id', [$user->id])->get();
        foreach ($courses as $course) {
            $course->location = json_decode($course->location); // Decode the JSON-encoded location string
        }
        if (is_null($courses)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $courses,
        ]);
    }

}
