<?php

namespace App\Http\Controllers\api;
use App\Models\Cource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class CourceController extends Controller
{
   
    public function index()
    {
        $courses = Cource::latest()->with('class:id,name','teacher')->get();
        foreach ($courses as $course) {
            $course->location = json_decode($course->location); // Decode the JSON-encoded location string
        }
        if (is_null($courses)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $courses,
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
    
        $user = Auth::guard('api')->user();
        $Cource = new Cource();
        $Cource->name = $req->name;
        $Cource->user_id = $user->id;
        $Cource->details = $req->details;
        $Cource->expertise = $req->expertise;
        $Cource->class_id = $req->class_id;
        $Cource->subject = $req->subject;
        $Cource->image = $req->image;
        $Cource->video = $req->video;
        $Cource->location = json_encode($req->location); // Store location as JSON-encoded string
        $Cource->save();
    
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Add Cource created successfully',
            'data' => $Cource,
        ], 200);
    }
    


    public function show($id)
{
    $course = Cource::with('class:id,name','teacher')->where('id',$id)->first();

    if (is_null($course)) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found'
        ], 404);
    }
    $course->location = json_decode($course->location); // Decode the JSON-encoded location string

    return response()->json([
        'success' => true,
        'data' => $course,
    ], 200);
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
        if (!empty($req->input('image'))) {
            $video->image = $req->input('image');
        }

        if (!empty($req->input('video'))) {
            $video->video = $req->input('video');
        }
        
        if (!empty($req->input('location'))) {
            $video->location = $req->input('location');
        } 
        
        if (!empty($req->input('subject'))) {
            $video->subject = $req->input('subject');
        } 
        
        if (!empty($req->input('class_id'))) {
            $video->class_id = $req->input('class_id');
        } 
        
        if (!empty($req->input('expertise'))) {
            $video->expertise = $req->input('expertise');
        }
        if (!empty($req->input('details'))) {
            $video->details = $req->input('details');
        }
        if (!empty($req->input('name'))) {
            $video->name = $req->input('name');
        }
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

    public function indexgetTeacher($user_id)
    {
        $user = User::find($user_id);
        if ($user === null) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }
        $courses = Cource::latest()->with('class:id,name','teacher')->whereIn('user_id', [$user->id])->get();
        foreach ($courses as $course) {
            $course->location = json_decode($course->location); // Decode the JSON-encoded location string
        }
        if (is_null($courses)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $courses,
        ]);
    }



    // public function search(Request $request)
    // {
    //     $query = Cource::query();
    
    //     // Apply filters based on request parameters
    //     if ($request->input('class_id')) {
    //         $query->where('class_id', $request->input('class_id'));
    //     }
    
    //     if ($request->input('subject_id')) {
    //         $query->where('subject_id', $request->input('subject_id'));
    //     }
    
    //     if ($request->input('teacher_id')) {
    //         $query->whereHas('teacher', function ($subquery) use ($request) {
    //             $subquery->where('id', $request->input('teacher_id'));
    //         });
    //     }
    
    //     if ($request->input('location')) {
    //         $query->where('location', 'LIKE', '%' . $request->input('location') . '%');
    //     }
    
    //     if ($request->input('name')) {
    //         $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
    //     }
    
    //     if ($request->input('subject_name')) {
    //         $query->whereHas('subject', function ($subquery) use ($request) {
    //             $subquery->where('name', 'LIKE', '%' . $request->input('subject_name') . '%');
    //         });
    //     }
    
    //     if ($request->input('teacher_price')) {
    //         $query->whereHas('teacher', function ($subquery) use ($request) {
    //             $subquery->where('price', $request->input('teacher_price'));
    //         });
    //     }
    
    //     if ($request->input('teacher_volunteer')) {
    //         $query->whereHas('teacher', function ($subquery) use ($request) {
    //             $subquery->where('volunteer', $request->input('teacher_volunteer'));
    //         });
    //     }
    
    //     $courses = $query->with('class:id,name', 'subject:id,name', 'teacher')
    //         ->latest()
    //         ->get();
    
    //     foreach ($courses as $course) {
    //         $course->location = json_decode($course->location); // Decode the JSON-encoded location string
    //     }
    
    //     if ($courses->isEmpty()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data not found.',
    //         ]);
    //     }
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All data retrieved successfully.',
    //         'data' => $courses,
    //     ]);
    // }
    
    
    public function search(Request $request)
    {
        $query = Cource::query();
    
        // Apply filters based on request parameters
        if ($request->input('class_id')) {
            $query->where('class_id', $request->input('class_id'));
        }


        if ($request->input('teacher_id')) {
            $query->whereHas('teacher', function ($subquery) use ($request) {
                $subquery->where('id', $request->input('teacher_id'));
            });
        }
        if ($request->has('location')) {
            $locations = $request->input('location');
            $query->where(function ($subquery) use ($locations) {
                foreach ($locations as $location) {
                    $subquery->orWhere('location', 'LIKE', '%' . $location . '%');
                }
            });
        }

        
        if ($request->input('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('subject')) {
            $query->where('subject', 'LIKE', '%' . $request->input('subject') . '%');
        }
    
    
        if ($request->input('teacher_price')) {
            $query->whereHas('teacher', function ($subquery) use ($request) {
                $subquery->where('price', $request->input('teacher_price'));
            });
        }

        if ($request->input('teacher_city')) {
            $query->whereHas('teacher', function ($subquery) use ($request) {
                $subquery->where('city', $request->input('teacher_city'));
            });
        }
        if ($request->input('teacher_volunteer')) {
            $query->whereHas('teacher', function ($subquery) use ($request) {
                $subquery->where('volunteer', $request->input('teacher_volunteer'));
            });
        }
        $start = $request->input('start', 0); // Starting index, default is 0
        $length = $request->input('length', 1000); // Number of items per page, default is 10
        $courses = $query->with('class:id,name', 'subject:id,name', 'teacher')
            ->latest()
            ->skip($start)
            ->take($length)
            ->get();
    
        foreach ($courses as $course) {
            $course->location = json_decode($course->location); // Decode the JSON-encoded location string
        }
    
        if ($courses->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found.',
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'All data retrieved successfully.',
            'data' => $courses,
        ]);
    }

    // public function allSearch(Request $request)
    // {
    //     $query = $request->input('query');
    //     $users = User::where('name', 'LIKE', "%$query%")->select('id','name','last_name')->get();
    //     $courses = Cource::where('name', 'LIKE', "%$query%")
    //                     ->orWhereHas('subject', function ($subQuery) use ($query) {
    //                         $subQuery->where('name', 'LIKE', "%$query%");
    //                     })
    //                     ->orWhereHas('class', function ($subQuery) use ($query) {
    //                         $subQuery->where('name', 'LIKE', "%$query%");
    //                     })
    //                     ->select('id','name','subject_id','class_id')->get();
    //     return response()->json([
    //         'success' => true,
    //         'users' => $users,
    //         'courses' => $courses
    //     ]);
    // }

    public function allSearch(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%$query%")->select('id','name','last_name')->get();
        $courses = Cource::where('name', 'LIKE', "%$query%")
                        ->orWhereHas('class', function ($subQuery) use ($query) {
                            $subQuery->where('name', 'LIKE', "%$query%");
                        })
                        ->select('id','name','class_id')->get();
        return response()->json([
            'success' => true,
            'users' => $users,
            'courses' => $courses
        ]);
    }


    public function getUserPriceRange()
{
    $maxPrice = User::max('price');
    $minPrice = User::min('price');

    return response()->json([
        'success' => true,
        'message' => 'Data susccessfull',
        'data' => [
            'max_price' => $maxPrice,
            'min_price' => $minPrice
        ],
    ]);
}


    
    

}
