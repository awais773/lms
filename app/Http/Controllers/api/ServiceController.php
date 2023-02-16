<?php

namespace App\Http\Controllers\api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function index()
    {
        $Service = Service::latest()->get();
        if (is_null($Service)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Service,
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
        $Service = new Service();
        $Service->name = $req->name;
        $Service->description = $req->description;
        if ($image = $req->file('image')) {
            $destinationPath = 'Service/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            $Service->image = $profileImage;
        }
        $Service->save();
        if (is_null($Service)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Subject created successfully',
            'data' => $Service,
        ],200);
    }

    public function show($id)
    {
        $Service = Service::where('id', $id)->first();
        if (is_null($Service)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Service,
        ],200);
    } 

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Service = Service::find($id);
        $Service->name = $request->name;
        $Service->description = $request->description;
        if ($image = $request->file('image')) {
            $destinationPath = 'Service/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            $Service->image = $profileImage;
        }
        $Service->update();
        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully.',
            'data' => $Service,
        ],200);
    }

    public function destroy($id)
    {
        $Service = Service::find($id);
        if (!empty($Service)) {
            $Service->delete();
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