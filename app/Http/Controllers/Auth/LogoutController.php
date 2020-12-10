<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class LogoutController extends Controller
{
    public function action(Request $request)
    {


       auth()->logout();

        $token = $request->header('Authorization');

        auth()->invalidate(true);

        return response()->json(['message' => "logout"]);
    }
}
