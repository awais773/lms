<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $Category = Category::latest()->get();
        if (is_null($Category)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Category,
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
        $Category = new Category();
        $Category->name = $req->name;
        $Category->description = $req->description;
        $Category->save();
        if (is_null($Category)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Category created successfully',
            'data' => $Category,
        ]);
    }

    public function show($id)
    {
        $Category = Category::where('id', $id)->first();
        if (is_null($Category)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Category,
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
        $Category = Category::find($id);
        $Category->name = $request->name;
        $Category->description = $request->description;
        $Category->update();
        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $Category,
        ]);
    }

    public function destroy($id)
    {
        $Category = Category::find($id);
        if (!empty($Category)) {
            $Category->delete();
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

