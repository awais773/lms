<?php

namespace App\Http\Controllers\api;
use App\Models\BanksPayment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class PaymentController extends Controller
{
   
    public function index()
    {
        $Payment = BanksPayment::get();
        if (is_null($Payment)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Payment,
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
        $Payment = new BanksPayment();
        $Payment->code = $req->code;
        $Payment->user_id = $user->id;
        $Payment->mobile_no = $req->mobile_no;
        $Payment->account_name = $req->account_name;
        $Payment->account_no = $req->account_no;
        $Payment->bank_name = $req->bank_name;
        $Payment->type = $req->type;
        $Payment->save();
        if (is_null($Payment)) {
            return response()->json([
                'success' => false,
                'message' => 'storage error'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Add Payment created successfully',
            'data' => $Payment,
        ], 200);
    }
    


    public function show($id)
{
    $Payment = BanksPayment::where('user_id',$id)->get();
    if (is_null($Payment)) {
        return response()->json([
            'success' => false,
            'message' => 'Payment not found'
        ], 404);
    }
    return response()->json([
        'success' => true,
        'data' => $Payment,
    ], 200);
}

   
    public function destroy($id)
    {
        $Payment = BanksPayment::find($id);
        if (!empty($Payment)) {
            $Payment->delete();
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

    public function update(Request $req, $id)
    {
        $Payment = BanksPayment::find($id);
        if (is_null($Payment)) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }
        $validator = Validator::make($req->all(), []);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toJson(),
            ], 400);
        }
        $Payment->code = $req->code;
        $Payment->mobile_no = $req->mobile_no;
        $Payment->account_name = $req->account_name;
        $Payment->account_no = $req->account_no;
        $Payment->bank_name = $req->bank_name;
        $Payment->type = $req->type;
        $Payment->save();
        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $Payment,
        ], 200);
    }


    // public function stripePost(Request $request)
    // {
    //     try {
    //         $stripe = new \Stripe\StripeClient(
    //             env('STRIPE_SECRET'));
    //       $payment =  $stripe->tokens->create([
    //           'card' => [
    //             'number' => $request->number,
    //             'exp_month' => $request->exp_month,
    //             'exp_year' => $request->exp_year,
    //             'cvc' => $request->cvc,
    //           ],
    //         ]);
    //         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    //        $response = $stripe->charges->create([
    //           'amount' =>$request->amount,
    //           'currency' => 'usd',
    //           'source' => $request->$payment->id,
    //           'description' => $request->description,
    //         ]);            
    //         return response([$response->status], 201);
    //     } catch (\Exception $e) {
    //         return response([
    //             'success' => false,
    //             $e->getMessage()
    //         ], 400);
    //     }
    
    //     return response([
    //         'message' => 'Invalid Email or password.'
    //     ], 401);
    // }

    public function stripePost(Request $request)
{
    try {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $payment = $stripe->tokens->create([
            'card' => [
                'number' =>$request->number, // Test card number
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvc,
            ],
        ]);
        
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        dd($payment->id);
        $response = $stripe->charges->create([
            'amount' => $request->amount,
            'currency' => 'usd',
            'source' => $payment->id, // Use the token ID from the test token
            'description' => $request->description,
        ]);
        
        return response([$response->status], 201);
    } catch (\Exception $e) {
        return response([
            'success' => false,
            $e->getMessage()
        ], 400);
    }

    return response([
        'message' => 'Invalid Email or password.'
    ], 401);
}


// public function stripePost(Request $request)
// {
//     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//     Stripe\Charge::create ([
//             "amount" => 100*100,
//             "currency" => "INR",
//             "source" => $request->stripeToken,
//             "description" => "This payment is testing purpose of techsolutionstuff",
//     ]);

       
//     return response([
//         'message' => 'success'
//     ], 401);
// }

}