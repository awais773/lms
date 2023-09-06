<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\User;
use App\Models\Review;
use App\Models\AdminUser;
use App\Models\ChatMessage;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Guards\TokenGuard;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{

    private $success = false;
    private $message = '';
    private $data = [];
    //
    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson() 
                'message' => 'Email already exist',

            ], 400);
        }

        $user = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'country' => $request->country,
            // 'mobile_number' => $request->mobile_number,
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


    public function adminlogin(Request $request)
    {
        $user = AdminUser::where("email", request('email'))->first();
        if(!isset($user)){
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Please Check your Credentials'
            ], 401);        }
        if (!Hash::check(request('password'), $user->password)) {
            return "Incorrect password";
        } 
        $tokenResult = $user->createToken('admin_users');
        // $user->token_type = 'Bearer';
        return response()->json([
            'success' => true,
            'message' => 'login successfull',
            'user' => $user,
            'token'=>  $tokenResult->accessToken,

        ], 200);
    }

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {

        auth()->guard('api')->logout();

        return response()->json([
            'Success' => true,
            'message' => 'User successfully signed out'

        ], 200);
    }
    // public function otpVerification(Request $request)
    // {
    //     $otp = $request->input('otp');
    //     $id = $request->user()->id;
    //     if (!empty($otp)) {
    //         $obj = AdminUser::where('otp_number', $otp)->where('id', $id)->first();
    //         if (!empty($obj)) {
    //             $obj->otp_verify = 1;
    //             $obj->save();
    //             $user = AdminUser::find($id);
    //             $token = $user->createToken('assessment')->accessToken;
    //             $user = $user->toArray();
    //             $this->data['token'] = 'Bearer ' . $token;
    //             $this->data['user'] = $user;
    //             $this->message = ' successfully';
    //             $this->success = true;
    //         } else {
    //             $this->message = 'Please enter valid otp number';
    //             $this->success = false;
    //         }
    //     }

    //     return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    // }

    // public function forgotPassword(Request $request)
    // {
    //     $user = $request->email;
    //     $checkEmail = AdminUser::where('email', $user)->first();
    //     if ($checkEmail) {
    //         $otp = rand(100000, 999999);
    //         $checkEmail->otp_number = $otp;
    //         $checkEmail->update();
    //         Mail::to($request->email)->send(new OtpVerificationMail($otp));
    //         $token = $checkEmail->createToken('assessment')->accessToken;
    //         $this->$checkEmail['token'] = 'Bearer ' . $token;
    //         return response()->json([
    //             'success' => 'true', 'message' => 'Otp sent successfully. Please check your email!',
    //             'data' => $data = ([
    //                 'token' => $token
    //             ])
    //         ]);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'this email is not exits']);
    //     }
    // }


    public function adminProfile(Request $request)
    {
//         $user = Auth::guard('api')->user();
// dd( $user);
        $id = $request->user()->id;
        $obj = AdminUser::find($id);
        if ($obj) {
            if (!empty($request->input('name'))) {
                $obj->name = $request->input('name');
            }
            if (!empty($request->input('email'))) {
                $obj->email = $request->input('email');
            }
            if (!empty($request->input('password'))) {
                $obj->password = Hash::make($request->input('password'));
            }
            if (!empty($request->input('role_id'))) {
                $obj->role_id = $request->input('role_id');
            }
            if ($obj->save()) {
                $this->data = $obj;
                $this->success = true;
                $this->message = 'Profile is updated successfully';
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data,]);
    }

    // public function updatePassword(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required',
    //         'password' => 'required|min:6',
    //         'confirm_password' => 'required|same:password'
    //     ]);
    //     $user = AdminUser::where('email', $request->email)->where('otp_verify', 1)->first();
    //     // $user = User::where('email', $email)->where('otp_verify', 1)->first();

    //     if ($user) {
    //         // $user['is_verified'] = 0;
    //         // $user['token'] = '';
    //         $user['password'] = Hash::make($request->password);
    //         $user->save();
    //         return response()->json(['success' => 'True', 'message' => 'Success! password has been changed',]);
    //     }
    //     return response()->json(['success' => false, 'message' => 'Failed! something went wrong',]);
    // }

      public function dashboard(){
        $studentlatest = User::where('type', '2')
        ->orderBy('created_at', 'desc') // Order by 'created_at' in descending order
        ->take(10) // Limit to the latest 10 records
        ->get();
    
       $teacherlatest = User::where('type', '1')
        ->orderBy('created_at', 'desc') // Order by 'created_at' in descending order
        ->take(10) // Limit to the latest 10 records
        ->get();

         $user = User::where('type','2')->count();
         $teacher = User::where('type','1')->count();
        $currentMonth = Carbon::now()->month;
        $currentMonthTeacher = DB::table('users')
        ->whereMonth('created_at', '=', $currentMonth)
         ->where('type','1')->count();
         $currentMonthStudent = DB::table('users')
         ->whereMonth('created_at', '=', $currentMonth)
          ->where('type','2')->count();
         if (is_null($user & $teacher) ) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'total_student' => $user,
            'total_teacher' => $teacher,
            'currentMonthTeacher' => $currentMonthTeacher,
            'currentMonthStudent' => $currentMonthStudent,
            'student' => $studentlatest,
            'teacher' => $teacherlatest,
        ],200);
    }



    public function addBlog(Request $req)
    {
        $video = new Blog();
        $validator = Validator::make($req->all(), [
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toJson(),
            ], 400);
        }
        if ($file = $req->file('image')) {
            $video_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $video_full_name = $video_name . '.' . $ext;
            $upload_path = 'blog/';
            $video_url = $upload_path . $video_full_name;
            $file->move($upload_path, $video_url);
            $video->image = $video_url;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'Blog Added successfully',
            'data' => $video,
        ], 200);
    }


    public function update(Request $req, $id)
    {
        $video = Blog::find($id);
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
        if ($file = $req->file('image')) {
            $video_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $video_full_name = $video_name . '.' . $ext;
            $upload_path = 'blog/';
            $video_url = $upload_path . $video_full_name;
            $file->move($upload_path, $video_url);
            $video->image = $video_url;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->save();
        return response()->json([
            'success' => true,
            'message' => 'blog updated successfully',
            'data' => $video,
        ], 200);
    }
      
    public function show($id)
    {
        $Cource = Blog::where('id',$id)->first();
        if (is_null($Cource)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Cource,
        ]);
    }


    public function blogGet()
    {
        $Blog = Blog::latest()->get();
        if (is_null($Blog)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Blog,
        ],200);
    }


    public function blogDestroy($id)
    {
        $Blog = Blog::find($id);
        if (!empty($Blog)) {
            $Blog->delete();
            return response()->json([
                'success' => true,
                'message' => ' delete successfuly',
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again ',
            ]);
        }
    }


    public function reviewAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = Auth::guard('api')->user();
        $reviewAdd = new Review();
        $reviewAdd->review = $request->review;
        $reviewAdd->ratting = $request->ratting;
        $reviewAdd->status = $request->status;
        $reviewAdd->teacher_id = $request->teacher_id;
        $reviewAdd->student_id =$user->id;
        $reviewAdd->save();
        if ($request->has('message_id')) {
            $chatMessage = ChatMessage::find($request->message_id);
            if ($chatMessage) {
                $chatMessage->delete();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'review Add successfully.',
            'data' => $reviewAdd,
        ],200);
    }

    public function reviewUpdate(Request $request, $id)
    {
        $obj = Review::find($id);
         if ($obj) {
            if (!empty($request->input('status'))) {
                $obj->status = $request->input('status');
            }
            if (!empty($request->input('teacher_id'))) {
                $obj->teacher_id = $request->input('teacher_id');
            }

            if (!empty($request->input('student_id'))) {
                $obj->student_id = $request->input('student_id');
            }

            if (!empty($request->input('ratting'))) {
                $obj->ratting = $request->input('ratting');
            }

            if (!empty($request->input('review'))) {
                $obj->review = $request->input('review');
            }
             $obj->save();

        }
        return response()->json([
            'success' => true,
            'message' => 'review is updated successfully',
            'data' => $obj,
        ]);
    }

    public function reviewDestroy($id)
    {
        $Review = Review::find($id);
        if (!empty($Review)) {
            $Review->delete();
            return response()->json([
                'success' => true,
                'message' => 'delete successfuly',
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again',
            ]);
        }
    }

    public function ReviewGet()
    {
        $Review = Review::with('teacher:id,name','student:id,name')->get();
        if (is_null($Review)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Review,
        ],200);
    }

    public function ReviewshowId($id)
    {
        $Review = Review::with('teacher:id,name','student:id,name,image')->where('teacher_id' , $id)->get();
        if (is_null($Review)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Review,
        ],200);
    }


    public function ReviewStatus()
    {
        $Review = Review::with('teacher:id,name','student:id,name')->where('status','report')->get();
        if (is_null($Review)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Review,
        ],200);
    }


    public function ReviewGetTeacherAll()
    {
        $user = Auth::guard('api')->user();
        $Review = Review::with('teacher:id,name','student:id,name')->where('teacher_id',$user->id)->get();
        if (is_null($Review)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Review,
        ],200);
    }

    public function ReviewGetTeacher($id)
    {
        $Review = Review::with('teacher:id,name','student:id,name')->find('techer_id', $id)->first();
        if (is_null($Review)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Review,
        ],200);
    }

    public function Addtestimonial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $Testimonial = new Testimonial();
        $Testimonial->teacher_id = $request->teacher_id;
        $Testimonial->description = $request->description;
        $Testimonial->save();
        return response()->json([
            'success' => true,
            'message' => 'Testimonial add successfully.',
            'data' => $Testimonial,
        ],200);
    }


    
    public function TestimonialGet()
    {
        $Testimonial = Testimonial::with('teacher')->get();
        if (is_null($Testimonial)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Testimonial,
        ],200);
    }


    public function TestimonialDestroy($id)
    {
        $Testimonial = Testimonial::find($id);
        if (!empty($Testimonial)) {
            $Testimonial->delete();
            return response()->json([
                'success' => true,
                'message' => 'delete successfuly',
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again',
            ]);
        }
    }


        
    public function TestimonialShow($id)
    {
        $Testimonial = Testimonial::with('teacher')->where('id',$id)->first();
        if (is_null($Testimonial)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Testimonial,
        ]);
    }


    public function deleteUser($id)
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

      
}



