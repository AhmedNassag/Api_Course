<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $users = User::get();
        return $this->apiResponse($users,'Ok',200);
    }


    public function show($id)
    {
        $user = User::find($id);
        if($user)
        {
            return $this->apiResponse($user,'Ok',200);
        }
        return $this->apiResponse(null,'The User Not Found',404);
    }


    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(),
        [
            'name'     => 'required|max:255',
            'email'    => 'required|email',
            'password' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::create($request->all());
        if($user)
        {
            return $this->apiResponse($user,'The User Save',201);
        }
        return $this->apiResponse(null,'The User Not Save',400);
    }


    public function update(Request $request ,$id)
    {
        $validator  = Validator::make($request->all(),
        [
            'name'     => 'required|max:255',
            'email'    => 'required|email',
            'password' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::find($id);
        if(!$user)
        {
            return $this->apiResponse(null,'The User Not Found',404);
        }
        $user->update($request->all());
        if($user)
        {
            return $this->apiResponse($user,'The User Update',201);
        }
    }


    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->apiResponse(null,'The User Not Found',404);
        }
        $user->delete($id);
        if($user)
        {
            return $this->apiResponse(null,'The User Deleted',200);
        }
    }
}
