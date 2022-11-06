<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource as ResourcesUserResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
class UserController extends Controller
{
    public function getUser(Request $request, $id){
        $user = User::where('id',$request->id)->get();
        return response()->json(UserResource::collection($user));


    }
}
