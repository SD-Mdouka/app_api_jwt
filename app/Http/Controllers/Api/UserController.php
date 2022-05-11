<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    use ApiResponse;
    public function index()
    {
        $user = UserResource::collection(User::all());
        return $this->apiResponse($user,'ok',200);
    }
    public function show($id)
    {
        $user = User::find($id);
        if($user)
        {
             return $this->apiResponse(new UserResource($user),'ok',200);
        }
        return $this->apiResponse(" ",'User Not Found',401);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::create($request->all());
         if($user)
        {
             return $this->apiResponse(new UserResource($user),'The user is created',201);
        }
        return $this->apiResponse(" ",'User Not Found',400);
    }
     public function update(Request $request ,$id){

       $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $user=User::find($id);

        if(!$user){
            return $this->apiResponse(null,'The users Not Found',404);
        }

        $user->update($request->all());

        if($user){
            return $this->apiResponse(new UserResource($user),'The users update',201);
        }

    }
    public function destroy($id){

        $user=User::find($id);

        if(!$user){
            return $this->apiResponse(null,'The user Not Found',404);
        }

        $user->delete($id);

        if($user){
            return $this->apiResponse(null,'The user deleted',200);
        }

    }

}