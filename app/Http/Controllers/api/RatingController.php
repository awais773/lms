<?php

namespace App\Http\Controllers\api;

use App\Models\Rating;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    
    public function index()
    {
        $Contact = Contact::latest()->get();
        if (is_null($Contact)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Contact,
        ]);
    }


    public function store(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);
        
        $rating = new Rating([
            'rating' => $validatedData['rating'],
        ]);
         $rating->rater_id = $request->user()->id;
          $rating->user_id = $user->id;

        $rating->save();
        if (is_null($rating)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'rating created successfully',
            'data' => $rating,
        ]);
    }
  
    public function getRating(User $user)
    {
        // $all = User::find($user);
        $avgRating = $user->ratings()->avg('rating');
    
        if (is_null($avgRating)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ],);
        }
        return response()->json([
            'success' => true,
            'message' => 'average_rating  successfully',
            'data' => $avgRating,
        ]);
    }
}
