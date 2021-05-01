<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
class LoginController extends Controller
{


    public function action(Request $request)
    {

        if ($request->input('token')) {
            auth()->setToken($request->input('token'));

            $user = auth()->authenticate();

            if ($user) {
                //return response()->json([
                //    'success' => true,
                //    'data' => $request->user(),
                //    'token' => $request->input('token')
                //], 200);
               // return $request->input('token');
                return (new PrivateUserResource($request->user()))
                ->additional([
                    'meta' => [
                        'token' => $request->input('token')
                    ]
                ]);

            }
        }

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => ['Could not sign you in with those details.']
                ]
            ], 422);
        }

        return (new PrivateUserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

}
