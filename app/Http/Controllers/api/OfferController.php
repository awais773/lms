<?php
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Helpers\FilterFunctions;
use App\Http\Controllers\Controller;
use App\Models\Cource;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        $results = Offer::with('teacher','student')->get();
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
        $Offer = new Offer();
        $Offer->status = $req->status;
        $Offer->offer_price = $req->offer_price;
        $Offer->student_id = $req->student_id;
        $Offer->teacher_id = $req->teacher_id;        
        $Offer->description = $req->description;        
        $Offer->save();
        if (is_null($Offer)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'Add Offer created successfully',
            'data' => $Offer,
        ],200);
    }

    public function show($id)
    {
        $Offer = Offer::with('teacher','student')->where('id', $id)->first();
        if (is_null($Offer)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Offer,
        ],200);
    } 

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Offer = Offer::find($id);
        $Offer->status = $req->status;
        $Offer->offer_price = $req->offer_price;
        $Offer->student_id = $req->student_id;
        $Offer->teacher_id = $req->teacher_id;        
        $Offer->description = $req->description;        
        $Offer->update();
        return response()->json([
            'success' => true,
            'message' => 'Offer updated successfully.',
            'data' => $Offer,
        ],200);
    }

    public function destroy($id)
    {
        $Offer = Offer::find($id);
        if (!empty($Offer)) {
            $Offer->delete();
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


    public function offerGet($id)
    {
        $user = User::find($id); // Retrieve the user by ID from the users table
        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    
        $offer = Cource::where('user_id', $user->id)->select('details', 'image', 'name')->get();
        if ($offer->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }
    
        $data = [];
        foreach ($offer as $course) {
            $data[] = [
                'details' => $course->details,
                'image' => $course->image,
                'name' => $course->name,
                'price' => $user->price // Retrieve the price from the user model
            ];
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data Successfuly',
            'data' => $data,

        ], 200);
    }
        

}
