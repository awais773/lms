<?php

namespace App\Http\Controllers\api;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::latest()->get();
        return response()->json([ 
            'success'=>true,
            'message'=>'All Data susccessfull',
            'data'=>$data ],200);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //   'role_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Role::create([
         'name' => $request->name,                     
         ]);
         return response()->json([
            'success'=>true,
            'message'=>'Role created successfully' ,
            'data'=>$program,
            ],200);     
        }

   
    public function show($id)
    {
        $program = Role::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([
            'success'=>true,
            'data'=>$program,
            ],200);    
        }

     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            // 'role_name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Role::find($id);
        if (!empty($request->input('name'))) {
            $program->name = $request->input('name');
        }
        $program->update();        
        return response()->json([
            'success'=>true,
             'message'=>'Role updated successfully.',
             'data'=>$program,
             ],200);     }

    public function destroy($id)
    {
        $program=Role::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>'User delete successfuly',
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

