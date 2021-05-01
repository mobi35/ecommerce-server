<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\PrivateUserResource;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    public function action (RegisterRequest $request){



        $credentials = $request->only('email', 'password','role');


        $user = User::create($request->only('email','name','password','role'));
        return new PrivateUserResource($user);


    }
}
