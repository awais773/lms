<?php
namespace App\Http\Controllers\api;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{

    public function index()
    {
        $Subject = Subject::latest()->get();
        if (is_null($Subject)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Subject,
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
        $Subject = new Subject();
        $Subject->name = $req->name;
        $Subject->description = $req->description;
        if ($image = $req->file('image')) {
            $destinationPath = 'Subject/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            $Subject->image = $profileImage;
        }
        $Subject->save();
        if (is_null($Subject)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Subject created successfully',
            'data' => $Subject,
        ]);
    }

    public function show($id)
    {
        $Package = Subject::where('id', $id)->first();
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Subject = Subject::find($id);
        $Subject->name = $request->name;
        $Subject->description = $request->description;
        if ($image = $request->file('image')) {
            $destinationPath = 'Subject/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            $Subject->image = $profileImage;
        }
        $Subject->update();
        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully.',
            'data' => $Subject,
        ]);
    }

    public function destroy($id)
    {
        $Subject = Subject::find($id);
        if (!empty($Subject)) {
            $Subject->delete();
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
