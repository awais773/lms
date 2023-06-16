<?php
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Helpers\FilterFunctions;
use App\Http\Controllers\Controller;
use App\Models\Subject_Skill;
use Illuminate\Support\Facades\Validator;

class SubjectSkillsController extends Controller
{

    public function index(Request $request)
    {
        $results = Subject_Skill::get();
        foreach ($results as $course) {
            $course->subject_skills = json_decode($course->subject_skills); 
        }
        if (is_null($results)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $results,
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
        $Subject = new Subject_Skill();
        $Subject->subject_skills = json_encode($req->subject_skills); // Store location as JSON-encoded string
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
        ],200);
    }

    public function show($id)
    {
        $Package = Subject_Skill::where('id', $id)->first();
        $Package->subject_skills = json_decode($Package->subject_skills); // Decode the JSON-encoded location string
        if (is_null($Package)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Package,
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
        $Subject = Subject_Skill::find($id);
        $Subject->subject_skills = $request->subject_skills;
        $Subject->update();
        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully.',
            'data' => $Subject,
        ],200);
    }

    public function destroy($id)
    {
        $Subject = Subject_Skill::find($id);
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
