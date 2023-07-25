<?php
namespace App\Http\Controllers\api;
use App\Models\User;
use App\Models\Offer;
use App\Models\Cource;
use App\Models\Invoice;
use App\Models\Category;
use App\Models\ChatMessage;
use Pusher\Pusher;
use Illuminate\Http\Request;
use App\Helpers\FilterFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        $results = Offer::with('teacher','student','cource')->get();
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

    // public function store(Request $req)
    // {


    //     $validator = Validator::make($req->all(), [
    //         // 'title' => 'required|unique:dealer_add_societies',
    //         // 'title' => 'required|unique:dealer_add_societies,title,NULL,id,user_id,' . auth()->id(),
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'title already exists',
    //         ], 400);
    //     }    
    //     $user = $req->user();
    //     $Offer = new Offer();
    //     $Offer->status = $req->status;
    //     $Offer->offer_price = $req->offer_price;
    //     $Offer->student_id =  $user->id;
    //     $Offer->teacher_id = $req->teacher_id;
    //     $Offer->description = $req->description;
    //     $Offer->cource_id = $req->cource_id;
    //     // Retrieve the course object based on the provided cource_id
    //     $course = Cource::find($req->cource_id);
    //     if (!$course) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Course not found',
    //         ], 404);
    //     }

    //     $Offer->courses()->associate($course); // Associate the course with the Offer
    //     $offer = $Offer->save(); 
    //     if (!$offer) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error storing Offer',
    //         ], 400);
    //     }   
    //     $message = $req->input('message');
    //     $recipient = $req->input('teacher_id');
    //     $type = $req->input('type');
    //     // $offer = $req->input('offer');
    //     // Assuming you have user authentication configured
    //     $chatMessage = ChatMessage::create([
    //         'user_id' => $user->id,
    //         'sender_id' => $recipient,
    //         'message' => $message,
    //         'type' => $type,
    //         'offer' => $Offer, // Store the entire $Offer object
    //     ]);
    
    //     // Send the chat message to the recipient in real-time using Pusher
    //     $pusher = new Pusher(
    //         config('broadcasting.connections.pusher.key'),
    //         config('broadcasting.connections.pusher.secret'),
    //         config('broadcasting.connections.pusher.app_id'),
    //         [
    //             'cluster' => config('broadcasting.connections.pusher.options.cluster'),
    //             'useTLS' => true,
    //         ]
    //     );
    
    //     $pusher->trigger("chat-channel-{$recipient}", 'new-message', $chatMessage);
    
    //     // Mark previously unseen messages as seen
    //     ChatMessage::where('user_id', $recipient)
    //         ->where('sender_id', $user->id)
    //         ->where('seen', false)
    //         ->update(['seen' => true]);
    
    //     if (is_null($Offer)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'storage error'
    //         ]);
    //     }



    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Add Offer created successfully',
    //         'data' => $Offer,
    //         // 'course' => $Offer->courses, // Access the associated course
    //         'chat' => $chatMessage,
    //     ], 200);
    // }


    public function store(Request $req)
{
    // Validate the request data (if needed)
    $validator = Validator::make($req->all(), [
        // 'title' => 'required|unique:dealer_add_societies',
        // 'title' => 'required|unique:dealer_add_societies,title,NULL,id,user_id,' . auth()->id(),
    ]);
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'title already exists',
        ], 400);
    }

    try {
        // Set Stripe API secret key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a PaymentIntent with Stripe
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $req->offer_price,
            'currency' => 'usd',
        ]);

        // Check if PaymentIntent creation was successful
        if ($intent->status !== 'requires_payment_method') {
            return response([
                'success' => false,
                'error' => 'PaymentIntent creation failed. Please try again later.'
            ], 400);
        }
    } catch (\Exception $e) {
        // Return error response if an exception occurs during payment processing
        return response([
            'success' => false,
            'error' => $e->getMessage()
        ], 400);
    }

    // The rest of your code...
    $user = $req->user();
    $offer = new Offer(); // Renamed the variable to $offer
    $offer->status = $req->status;
    $offer->offer_price = $req->offer_price;
    $offer->student_id =  $user->id;
    $offer->teacher_id = $req->teacher_id;
    $offer->description = $req->description;
    $offer->strip_key = $intent->client_secret;
    $offer->cource_id = $req->cource_id;

    // Retrieve the course object based on the provided cource_id
    $course = Cource::find($req->cource_id);
    if (!$course) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found',
        ], 404);
    }

    $offer->courses()->associate($course);
    if (!$offer) {
     return response()->json([
     'success' => false,
    'message' => 'Error storing Offer',
    ], 400);
        }  // Associate the course with the Offer
    $offer->save(); // Save the offer

    // Create a chat message
    $message = $req->input('message');
    $recipient = $req->input('teacher_id');
    $type = $req->input('type');
    $chatMessage = ChatMessage::create([
        'user_id' => $user->id,
        'sender_id' => $recipient,
        'message' => $message,
        'type' => $type,
        'offer' => $offer, // Store the entire $offer object
    ]);

    // Send the chat message to the recipient in real-time using Pusher
    $pusher = new Pusher(
        config('broadcasting.connections.pusher.key'),
        config('broadcasting.connections.pusher.secret'),
        config('broadcasting.connections.pusher.app_id'),
        [
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => true,
        ]
    );

    try {
        $pusher->trigger("chat-channel-{$recipient}", 'new-message', $chatMessage);
    } catch (\Pusher\PusherException $e) {
        // Log or handle the Pusher error
        // Return an appropriate response to the client
    }

    // Mark previously unseen messages as seen
    ChatMessage::where('user_id', $recipient)
        ->where('sender_id', $user->id)
        ->where('seen', false)
        ->update(['seen' => true]);

    // Return the response
    return response()->json([
        'success' => true,
        'message' => 'Add Offer created successfully',
        'data' => $offer,
        'chat' => $chatMessage,
    ], 200);
}
    

    public function show($id)
    {
        $Offer = Offer::with('teacher','student','cource')->where('id', $id)->first();
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
        $Offer->cource_id = $req->cource_id;        
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


    // public function offerGet($id)
    // {
    //     $user = User::find($id); // Retrieve the user by ID from the users table
    //     if (is_null($user)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found'
    //         ], 404);
    //     }
    
    //     $offer = Cource::where('user_id', $user->id)->select('details', 'image', 'name','id','class_id')->get();
    //     if ($offer->isEmpty()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data not found'
    //         ], 404);
    //     }
    
    //     $data = [];
    //     foreach ($offer as $course) {
    //         $data[] = [
    //             'id' => $course->id,
    //             'details' => $course->details,
    //             'image' => $course->image,
    //             'name' => $course->name,
    //             'price' => $user->price, // Retrieve the price from the user model
    //             'class_id' => $course->class_id
    //         ];
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All Data Successfuly',
    //         'data' => $data,

    //     ], 200);
    // }

    public function offerGet($id)
{
    $user = User::find($id); // Retrieve the user by ID from the users table
    if (is_null($user)) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 404);
    }

    $offers = Cource::where('user_id', $user->id)->select('details', 'image', 'name', 'id', 'class_id')->get();
    if ($offers->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Data not found'
        ], 404);
    }

    $data = [];
    foreach ($offers as $course) {
        $class = Category::find($course->class_id);
        if (!is_null($class)) {
            $data[] = [
                'id' => $course->id,
                'details' => $course->details,
                'image' => $course->image,
                'name' => $course->name,
                'price' => $user->price, // Retrieve the price from the user model
                'class_id' => $course->class_id,
                'class_name' => $class->name, // Assuming the class name is stored in a 'name' column
            ];
        }
    }
    return response()->json([
        'success' => true,
        'message' => 'All Data Successfully',
        'data' => $data,
    ], 200);
}


    public function invoice(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());         
        }
        $Offer = Offer::find($id);
        $Offer->status = 'Paid';      
        $Offer->save();
        $user = $req->user();
        $Invoice = new Invoice();
        $Invoice->offer_price = $Offer->offer_price;
        $Invoice->student_id = $user->id;
        $Invoice->teacher_id = $Offer->teacher_id;        
        $Invoice->save();
        return response()->json([
            'success' => true,
            'message' => 'Offer Accept successfully.',
            'data' => $Invoice,
        ],200);
    }


    public function invoiceGet(Request $request)
    {
        $results = Invoice::with('teacher','student')->get();
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


    public function invoiceShow($id)
    {
        $Invoice = Invoice::with('teacher','student')->where('id', $id)->first();
        if (is_null($Invoice)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Invoice,
        ],200);
    } 
        

}
