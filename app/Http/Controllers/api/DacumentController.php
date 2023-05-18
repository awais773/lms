<?php

namespace App\Http\Controllers\api;
use App\Models\Cource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseFile;
use Illuminate\Support\Facades\Validator;

class DacumentController extends Controller
{
   
    public function index()
    {
        $Cource = CourseFile::latest()->get();
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
        $video = new CourseFile();
        $validator = Validator::make($req->all(), [

        ]);
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
            $upload_path = 'video/';
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
        if ($file = $req->file('cover_image')) {
            $thumbnail_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $thumbnail_full_name = $thumbnail_name . '.' . $ext;
            $upload_path = 'coverImage/';
            $thumbnail_url = $upload_path . $thumbnail_full_name;
            $file->move($upload_path, $thumbnail_url);
            $video->cover_image = $thumbnail_url;
        }
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'Dacuments Added successfully',
            'data' => $video,
        ], 200);
    }

   
    public function show($id)
    {
        $Cource = CourseFile::where('id',$id)->first();
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
        $video = CourseFile::find($id);
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
            $upload_path = 'video/';
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
        if ($file = $req->file('cover_image')) {
            $thumbnail_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $thumbnail_full_name = $thumbnail_name . '.' . $ext;
            $upload_path = 'coverImage/';
            $thumbnail_url = $upload_path . $thumbnail_full_name;
            $file->move($upload_path, $thumbnail_url);
            $video->cover_image = $thumbnail_url;
        }
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'Dacuments updated successfully',
            'data' => $video,
        ], 200);
    }

   
    public function destroy($id)
    {
        $Cource = CourseFile::find($id);
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
