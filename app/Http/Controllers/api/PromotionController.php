<?php

namespace App\Http\Controllers\api;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{

    public function index()
    {
        $Promotion = Promotion::latest()->with('user')->get();
        if (is_null($Promotion)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Promotion,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        $Promotion = new Promotion();
        $Promotion->package_name = $request->package_name;
        $Promotion->user_id = $request->user_id;
        $Promotion->description = $request->description;       
        $Promotion->package_amount = $request->package_amount;       
        $Promotion->save();

        
        if (is_null($Promotion)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Promotion created successfully',
            'data' => $Promotion,
        ]);
    }

    public function show($id)
    {
        $Promotion = Promotion::where('id', $id)->first();
        if (is_null($Promotion)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Promotion,
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
        $Promotion = Promotion::find($id);
        $Promotion->package_name = $request->package_name;
        $Promotion->user_id = $request->user_id;
        $Promotion->description = $request->description;
        $Promotion->package_amount = $request->package_amount;       
        $Promotion->update();
        return response()->json([
            'success' => true,
            'message' => 'Promotion updated successfully.',
            'data' => $Promotion,
        ]);
    }

    public function destroy($id)
    {
        $Promotion = Promotion::find($id);
        if (!empty($Promotion)) {
            $Promotion->delete();
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