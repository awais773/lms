<?php

namespace App\Http\Controllers\api;

use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{

    public function index()
    {
        $Ads = Ads::latest()->get();
        if (is_null($Ads)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Ads,
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
        $Ads = new Ads();
        $Ads->name = $req->name;
        $Ads->description = $req->description;
        if ($image = $req->file('video')) {
            $destinationPath = 'adsVideo/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['video'] = "$profileImage";
            $Ads->video = $profileImage;
        }
        $Ads->save();
        if (is_null($Ads)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Ads created successfully',
            'data' => $Ads,
        ]);
    }

    public function show($id)
    {
        $Ads = Ads::where('id', $id)->first();
        if (is_null($Ads)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Ads,
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
        $Ads = Ads::find($id);
        $Ads->name = $request->name;
        $Ads->description = $request->description;
        if ($image = $request->file('video')) {
            $destinationPath = 'adsVideo/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['video'] = "$profileImage";
            $Ads->video = $profileImage;
        }
        $Ads->update();
        return response()->json([
            'success' => true,
            'message' => 'Ads updated successfully.',
            'data' => $Ads,
        ]);
    }

    public function destroy($id)
    {
        $Ads = Ads::find($id);
        if (!empty($Ads)) {
            $Ads->delete();
            return response()->json([
                'success' => true,
                'message' => 'delete successfuly',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again',
            ]);
        }
    }
}

