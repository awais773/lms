<?php

namespace App\Http\Controllers\api;
use App\Models\BanksPayment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    $Payment = BanksPayment::where('id',$id)->first();

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


}
