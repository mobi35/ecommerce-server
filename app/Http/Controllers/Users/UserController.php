<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    
    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

    public function users(){
        return PrivateUserResource::collection(User::get());
    }
}
