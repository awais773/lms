<?php

namespace App\Http\Controllers\api;

use Closure;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Mail\OtpVerificationMail;
use App\Mail\OtpVerificationMails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    private $success = false;
    private $message = '';
    private $data = [];
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson() 
                'message' => 'Email already exist',

            ], 400);
        }
        $randomId = rand(1000000, 9999999);
        $locations = $request->input('location');
       $locationString = json_encode($locations); 
        $user = User::create([
            // 'id' => $randomId, // Assign the random ID
            'name' => $request->name,
            'last_name' => $request->last_name,
            'city' => $request->city,
            'email' => $request->email,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
            'location' => $locationString, // Store locations as a string
            'type' => $request->type,
            'social_type' => $request->social_type,
            'password' => Hash::make($request->password)
        ]);
       $email = 'https://besttutorforyou.com/Login?type=verified';
        Mail::to($request->input('email'))->send(new OtpVerificationMail($email));
        $token = $user->createToken('Token')->accessToken;
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Failed to generate token'], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'login successfull',
            'user' => $user,
            'token' => $token,
            'user_id'=>$user->id
        ], 200);
    }


//  public function login(Request $request)
//     {
//         $data = [
//             'email' => $request->email,
//             'password' => $request->password,
//             'type' => $request->type,
//         ];

//         $credentials = [
//             'email' => $request->email,
//             'type' => $request->type,
//             'social_type' => $request->social_type,
//         ];
      
//         if (auth()->attempt($data)) {
//             $token = auth()->user()->createToken('Token')->accessToken;
//             return response()->json([
//                 'success' => true,
//                 'message' => 'login successfull',
//                 'user' => User::find(Auth::id()),
//                 'token' => $token,
//             ], 200);
//         }elseif ($check = User::where($credentials)->first()) {
//             $token = $check->createToken('Token')->accessToken;
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Login successful',
//                 'user' => User::find($check->id),
//                 'token' => $token,
//             ], 200);
//         }
//         else {
//             return response()->json([
//                 'success' => false,
//                 'error' => 'Unauthorized',
//                 'message' => 'Please Check your Credentials'
//             ], 401);
//         }
//     }

public function login(Request $request)
{
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'type' => $request->type,
    ];

    $user = User::where('email', $request->email)
                 ->where('type', $request->type)
                 ->first();
    if ($user && ($user->social_type === 'both' || $user->social_type === 'google')) {
        $token = $user->createToken('Token')->accessToken;
        $user->skills = json_decode($user->skills); // Decode the JSON-encoded skills property
        if ($request->has('isVerify')) {
            $user->isVerify = $request->input('isVerify');
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    } elseif (auth()->attempt($credentials)) {
        $user = auth()->user();
        $token = $user->createToken('Token')->accessToken;
        $user->skills = json_decode($user->skills); // Decode the JSON-encoded skills property
        if ($request->has('isVerify')) {
            $user->isVerify = $request->input('isVerify');
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'Unauthorized',
            'message' => 'Please check your credentials',
        ], 401);
    }
}

  public function newlogin(Request $request)
    {
        $credentials = $request->only('id', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = auth()->user();
            $token = $user->createToken('Token')->accessToken;
            $user->skills = json_decode($user->skills); // Decode the JSON-encoded skills property

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Invalid ID or password',
            ]);
        }
    }


   

    public function logout()
    {
        // auth()->guard('api')->logout();
        auth()->user()->token()->revoke();
        return response()->json([
            'Success' => true,
            'message' => 'User successfully signed out'

        ], 200);
    }
    
   public function otpVerification(Request $request)
    {
        $otp = $request->input('otp');
        $email = $request->input('email');
        
        $this->success = false;
        $this->message = 'Please enter a valid OTP number';
        $this->data = [];
        
        // Check if OTP and email are provided
        if (!empty($otp) && !empty($email)) {
            // Find the user by matching 'otp_number' and 'email'
            $user = User::where('otp_number', $otp)->where('email', $email)->first();
            
            if ($user) {
                $user->otp_verify = 1;
                $user->save();                
                $token = $user->createToken('assessment')->accessToken;                
                $userData = $user->toArray();
                $this->data['token'] = 'Bearer ' . $token;
                $this->data['user'] = $userData;                
                $this->success = true;
                $this->message = 'Verification successful';
            }
        }
        
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }
    

    public function forgotPassword(Request $request)
    {
        $user = $request->email;
        $checkEmail = User::where('email', $user)->first();
        if ($checkEmail) {
            $otp = rand(100000, 999999);
            $checkEmail->otp_number = $otp;
            $checkEmail->update();
            Mail::to($request->email)->send(new OtpVerificationMails($otp));
            $token = $checkEmail->createToken('assessment')->accessToken;
            $this->$checkEmail['token'] = 'Bearer ' . $token;
            return response()->json([
                'success' => 'true', 'message' => 'Otp sent successfully. Please check your email!',
                'data' => $data = ([
                    'token' => $token
                ])
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'this email is not exits']);
        }
    }


   public function updateProfile(Request $request,)
    {
        $id = $request->user()->id;
        $obj = User::find($id);       
         if ($obj) {
            if (!empty($request->input('cover_image'))) {
                $obj->cover_image = $request->input('cover_image');
            }
            if (!empty($request->input('image'))) {
                $obj->image = $request->input('image');
            }
            if (!empty($request->input('name'))) {
                $obj->name = $request->input('name');
            }
            if (!empty($request->input('last_name'))) {
                $obj->last_name = $request->input('last_name');
            }
            if (!empty($request->input('price'))) {
                $obj->price = $request->input('price');
            }
            if (!empty($request->input('expert'))) {
                $obj->expert = $request->input('expert');
            }
            if (!empty($request->input('email'))) {
                $obj->email = $request->input('email');
            }
            if (!empty($request->input('password'))) {
                $obj->password = Hash::make($request->input('password'));
            }
            if (!empty($request->input('mobile_number'))) {
                $obj->mobile_number = $request->input('mobile_number');
            }
            if (!empty($request->input('country'))) {
                $obj->country = $request->input('country');
            }
            if (!empty($request->input('location'))) {
                $obj->location = $request->input('location');
            }
            if (!empty($request->input('information'))) {
                $obj->information = $request->input('information');
            }
            if (!empty($request->input('type'))) {
                $obj->type = $request->input('type');
            }
            if (!empty($request->input('age'))) {
                $obj->age = $request->input('age');
            } 
             if (!empty($request->input('skills'))) {
                $obj->skills =  json_encode($request->input('skills'));
            }
             if (!empty($request->input('twitter_link'))) {
                $obj->twitter_link = $request->input('twitter_link'); 
            }
            if (!empty($request->input('nationality'))) {
                $obj->nationality = $request->input('nationality');
            }
           if (!empty($request->input('service'))) {
                $obj->service =  json_encode($request->input('service'));
            }
            if (!empty($request->input('address'))) {
                $obj->address = $request->input('address');
            }
             if (!empty($request->input('city'))) {
                $obj->city = $request->input('city');
            }
           if (!empty($request->input('volunteer'))) {
                $obj->volunteer = $request->input('volunteer');
            }
              if (!empty($request->input('qualification_id'))) {
                $obj->qualification_id = $request->input('qualification_id');
            }
            if (!empty($request->input('date_birth'))) {
                $obj->date_birth = $request->input('date_birth');
            }
             if (!empty($request->input('facbook_link'))) {
                $obj->facbook_link = $request->input('facbook_link');
            }
            if (!empty($request->input('insta_link'))) {
                $obj->insta_link = $request->input('insta_link');
            }
            if (!empty($request->input('youtub_link'))) {
                $obj->youtub_link = $request->input('youtub_link');
            }
            if (!empty($request->input('pack_price_1'))) {
                $obj->pack_price_1 = $request->input('pack_price_1');
            }
            if (!empty($request->input('pack_price_2'))) {
                $obj->pack_price_2 = $request->input('pack_price_2');
            }
            if (!empty($request->input('webcam_price'))) {
                $obj->webcam_price = $request->input('webcam_price');
            }

            if ($obj->save()) {
                $this->data = $obj;
                $this->success = true;
                $this->message = 'Profile is updated successfully';

            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 
        
        'data' => $this->data,
        
    
    ]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);
    
        $user = User::where('email', $request->email)->where('otp_verify', 1)->first();
    
        if ($user) {
            if ($user->social_type === 'google') {
                $user->social_type = 'both';
            } elseif ($user->social_type === null) {
                $user->social_type = null;
            }
    
            $user->password = Hash::make($request->password);
            $user->save();
    
            return response()->json(['success' => true, 'message' => 'Success! Password has been changed']);
        }
    
        return response()->json(['success' => false, 'message' => 'Failed! Something went wrong']);
    }
    
    
    
      public function PasswordChanged(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
        ]);
    
        $user = Auth::user();
        if ($user) {
            // Check if the old password is correct
            if (Hash::check($request->old_password, $user->password)) {
                $user['password'] = Hash::make($request->password);
                $user->save();
    
                return response()->json(['success' => true, 'message' => 'Success! Password has been changed']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed! Old password is incorrect']);
            }
        }
    
        return response()->json(['success' => false, 'message' => 'Failed! Something went wrong']);
    }

    public function instructor()
    {
        $data = User::with('qualification','cources.class:id,name')->where('type','1')->get();
        if (is_null($data)) {
            return response()->json('data not found');
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $data,
        ]);
    }
    
    // public function instructor()
    // {
    //     $users = User::with(['qualification', 'cources.class'])
    //         ->where('type', '1')
    //         ->get();
    
    //     if ($users->isEmpty()) {
    //         return response()->json('Data not found');
    //     }
    
    //     $userData = [];
    //     foreach ($users as $user) {
    //         $classData = [];
    //         foreach ($user->cources as $cource) {
    //             $classData[] = [
    //                 'class_id' => $cource->class->id,
    //                 'class_name' => $cource->class->name,
    //             ];
    //         }
    
    //         $userData[] = [
    //             'user_id' => $user->id,
    //             'class_data' => $classData,
    //         ];
    //     }
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All data retrieved successfully',
    //         'data' => $userData,
    //     ]);
    // }

    public function student()
    {
        $data = User::with('role')->where('type','2')->get();
        if (is_null($data)) {
            return response()->json('data not found',);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $data,
        ]);
    }

    public function delete($id)
    {
        $User = User::find($id);
        if (!empty($User)) {
            $User->delete();
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

         public function status($id)
          {
                $User = User::find($id);
                if ($User->active) {
                    $User->active = false;
                } else {
                    $User->active = true;
                }
                if (!empty($User)) {
                    $User->update();
                    return response()->json([
                        'success'=>true,
                        'message'=>'  Status Changed successfuly',
                        'data' => $User,
                    ],200);
                }
                else {
                    return response()->json([
                        'success'=>false,
                        'message'=>'something wrong try again ',
                    ]);
                }  
            }
            
            
             public function getTeacher()
            {
                $user = Auth::with('role')->guard('api')->user();
                $users = User::whereIn('id', $user)->get();
                if (is_null($users)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'data not found'
                    ],);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'All Data susccessfull',
                    'data' => $users,
                ]);
            }
            
            
            public function getOneTeacher($id)
            {
                $user = User::with('qualification')->where('id', $id)->first();
                if (is_null($user)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data not found'
                    ], 404);
                }
                
                $user->location = json_decode($user->location); 
              $user->skills = json_decode($user->skills);
                // Decode the JSON-encoded location string
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieval successful',
                    'data' => $user,
                ]);
            }


            public function resendEmail(Request $request)
            {
                $userId = $request->input('id');                
                $user = User::find($userId);
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found',
                    ]);
                }
                $email = 'https://besttutorforyou.com/verifytutor/' . $userId;
                // Send the email
                Mail::to($user->email)->send(new OtpVerificationMail($email));
                return response()->json([
                    'success' => true,
                    'message' => 'Email sent successfully',
                ]);
            }



            public function handle(Request $request)
            {
                $token = $request->header('Authorization');
                if (!$token) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Unauthorized'
                    ], 401);
                }
            
                // Extract the token from the header (remove 'Bearer ' prefix)
                $token = str_replace('Bearer ', '', $token);
            
                // Check if the token is valid
                // $user = User::where('api_token', $token)
                $user = Auth::guard('api')->user();
                if (!$user) {
                    return response()->json(['error' => 'Invalid token'], 401);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'valid token',
                  ]);
            }
            
                




       
    }


