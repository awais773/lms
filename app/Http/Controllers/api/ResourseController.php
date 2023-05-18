<?php

namespace App\Http\Controllers\api;
use App\Models\Cource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resourse;
use Illuminate\Support\Facades\Validator;

class ResourseController extends Controller
{
   
    public function index()
    {
        $Resouse = Resourse::latest()->get();
        if (is_null($Resouse)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Resouse,
        ],200);
    }


    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson()
                'message' => 'title already exist',

            ], 400);
        }
        if ($file = $req->file('image')) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'resourse/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $upload_path . $image_full_name);
                $image = $image_url;
                $blog = new Resourse();
                $blog->image = $image;
                $blog->title = $req->title;
                $blog->description = $req->description;
                $blog->save();
            }
        if (is_null($blog)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Resourse created successfully',
            'data' => $blog,
        ],200);
    }

   
    public function show($id)
    {
        $Resourse = Resourse::where('id',$id)->first();
        if (is_null($Resourse)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Resourse,
        ]);
    }



    public function update(Request $req, $id)
    {
        $video = Resourse::find($id);
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
        if ($file = $req->file('image')) {
            $video_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $video_full_name = $video_name . '.' . $ext;
            $upload_path = 'resourse/';
            $video_url = $upload_path . $video_full_name;
            $file->move($upload_path, $video_url);
            $video->image = $video_url;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'course updated successfully',
            'data' => $video,
        ], 200);
    }

   
    public function destroy($id)
    {
        $Resourse = Resourse::find($id);
        if (!empty($Resourse)) {
            $Resourse->delete();
            return response()->json([
                'success' => true,
                'message' => ' delete successfuly',
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again ',
            ]);
        }
    }
}
