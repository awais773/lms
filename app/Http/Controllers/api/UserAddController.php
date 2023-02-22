<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAddController extends Controller
{

    public function index()
    {
        $data = User::with('role')->get();
        if (is_null($data)) {
            return response()->json('data not found',);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                // 'message' => $validator->errors()->toJson()
                'message' => 'Email already exist',

            ], 400);
        } {
            $roleUsers = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                // 'block'=> $request->block,
                'password' => Hash::make($request->password)
            ]);
            $user = Auth::guard('api')->user();
            $token = $user->createToken('Token')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'User Create successfull',
                'user' => $roleUsers,
                'token' => $token,
            ], 200);
        }
    }

    public function show($id)
    {
        $program = User::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            'success' => true,
            'data' => $program,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $program = User::find($id);
        $program->name = $request->name;
        $program->email = $request->email;
        $program->role_id = $request->role_id;
        // $program->block = $request->block;
        $program->password = Hash::make($request->password);
        $program->update();
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $program,
        ], 200);
    }

    public function destroy($id)
    {
        $program = User::find($id);
        if (!empty($program)) {
            $program->delete();
            return response()->json([
                'success' => 'True',
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
