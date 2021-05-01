<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\JWTAuth;
use App\Models\User;
use App\Models\UserSocial;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
        $this->middleware(['social', 'web']);
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        try{
            $serviceUser = Socialite::driver($service)->stateless()->user();
        }catch(InvalidStateException $e){
            return redirect(env('CLIENT_BASE_URL'). '/account/social-callback?error=Unable to login using '. $service);
        }

        $email = $serviceUser->getEmail();
        if($service != 'google'){
            $email = $serviceUser->getId(). '@'. $service . '.local';
        }

        $user = $this->getExistingUser($serviceUser, $email, $service);
        $newUser = false;
        if(!$user){
            $newUser = true;
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $email,
                'password' => '',
                'role' => 'user'
            ]);
        }

        if ($this->needsToCreateSocial($user, $service)) {
            UserSocial::create([
                'user_id' => $user->id,
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);
         };


        return redirect(env('CLIENT_BASE_URL') . '/account/social-callback?token=' . $this->auth->fromUser($user) . '&origin=' . ($newUser ? 'register' : 'login'));
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
            $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
            return $userSocial ? $userSocial->user : null;
        }
        return User::where('email', $email)->orWhereHas('social', function($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}