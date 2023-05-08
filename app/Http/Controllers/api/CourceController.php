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
        $Cource = Cource::latest()->with('class:id,name','subject:id,name')->get();
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
            // 'thumbnail' => 'required',
            // 'video' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
    
            ], 400);
        }
        if ($file = $req->file('video')) {
            $video_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $video_full_name = $video_name . '.' . $ext;
            $upload_path = 'course/';
            $video_url = $upload_path . $video_full_name;
            $file->move($upload_path, $video_url);
    
            if ($thumbnail = $req->file('image')) {
                $thumbnail_name = md5(rand(1000, 10000));
                $ext = strtolower($thumbnail->getClientOriginalExtension());
                $thumbnail_full_name = $thumbnail_name . '.' . $ext;
                $upload_path = 'course/';
                $thumbnail_url = $upload_path . $thumbnail_full_name;
                $thumbnail->move($upload_path, $thumbnail_url);
            } else {
                $thumbnail_url = null;
            }
            $Cource = new Cource();
            $Cource->name = $req->name;
            $Cource->image = $thumbnail_url;
            $Cource->video = $video_url;
            $Cource->user_id = $req->user_id;
            $Cource->details = $req->details;
            $Cource->expertise = $req->expertise;
            $Cource->class_id = $req->class_id;
            $Cource->subject_id = $req->subject_id;
            $Cource->location = $req->location;
            
            $Cource->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Add Cource created successfully',
                'data' => $Cource,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cource upload failed'
            ], 400);
        }
    }

   
    public function show($id)
    {
        $Cource = Cource::with('class:id,name','subject:id,name')->where('id',$id)->first();
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
        if ($file = $req->file('video')) {
            $video_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $video_full_name = $video_name . '.' . $ext;
            $upload_path = 'course/';
            $video_url = $upload_path . $video_full_name;
            $file->move($upload_path, $video_url);
            $video->video = $video_url;
        }
        if ($file = $req->file('image')) {
            $thumbnail_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $thumbnail_full_name = $thumbnail_name . '.' . $ext;
            $upload_path = 'course/';
            $thumbnail_url = $upload_path . $thumbnail_full_name;
            $file->move($upload_path, $thumbnail_url);
            $video->image = $thumbnail_url;
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
}
