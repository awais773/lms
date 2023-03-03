<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OtpVerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson() 
                'message' => 'Email already exist',

            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
            'type' => $request->type,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('Token')->accessToken;
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'somthing Wrong',], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'login successfull',
            'user' => $user,
            'token' => $token,
        ], 200);
    }


    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'login successfull',
                'user' => User::with('role')->find(Auth::id()),
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Please Check your Credentials'
            ], 401);
        }
    }

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
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
        $id = $request->user()->id;
        if (!empty($otp)) {
            $obj = User::where('otp_number', $otp)->where('id', $id)->first();
            if (!empty($obj)) {
                $obj->otp_verify = 1;
                $obj->save();
                $user = User::find($id);
                $token = $user->createToken('assessment')->accessToken;
                $user = $user->toArray();
                $this->data['token'] = 'Bearer ' . $token;
                $this->data['user'] = $user;
                $this->message = ' successfully';
                $this->success = true;
            } else {
                $this->message = 'Please enter valid otp number';
                $this->success = false;
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    }

    public function forgotPassword(Request $request)
    {
        $user = $request->email;
        $checkEmail = User::where('email', $user)->first();
        if ($checkEmail) {
            $otp = rand(100000, 999999);
            $checkEmail->otp_number = $otp;
            $checkEmail->update();
            Mail::to($request->email)->send(new OtpVerificationMail($otp));
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


    public function updateProfile(Request $request)
    {
        $id = $request->user()->id;
        $obj = User::find($id);
        if ($obj) {
            if ($image = $request->file('image')) {
                $destinationPath = 'profileImage/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
                $obj->image = $profileImage;
            }
            if (!empty($request->input('name'))) {
                $obj->name = $request->input('name');
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
            if ($obj->save()) {
                $this->data = $obj;
                $this->success = true;
                $this->message = 'Profile is updated successfully';
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data,]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);
        $user = User::where('email', $request->email)->where('otp_verify', 1)->first();
        // $user = User::where('email', $email)->where('otp_verify', 1)->first();

        if ($user) {
            // $user['is_verified'] = 0;
            // $user['token'] = '';
            $user['password'] = Hash::make($request->password);
            $user->save();
            return response()->json(['success' => 'True', 'message' => 'Success! password has been changed',]);
        }
        return response()->json(['success' => false, 'message' => 'Failed! something went wrong',]);
    }

    public function instructor()
    {
        $data = User::with('role')->where('type','1')->get();
        if (is_null($data)) {
            return response()->json('data not found',);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $data,
        ]);
    }

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
                    ],200);
                }
                else {
                    return response()->json([
                        'success'=>false,
                        'message'=>'something wrong try again ',
                    ]);
                }  
            }
       
    }


