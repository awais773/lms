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
        $Package = Package::latest()->get();
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
        $Package->package_name = $req->package_name;
        $Package->monthly_price = $req->monthly_price;
        $Package->description = $req->description;
        $Package->details = $req->details;
        $Package->save();
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
        $Package = Package::where('id', $id)->first();
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

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Package = Package::find($id);
        $Package->package_name = $req->package_name;
        $Package->monthly_price = $req->monthly_price;
        $Package->description = $req->description;
        $Package->details = $req->details;
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
