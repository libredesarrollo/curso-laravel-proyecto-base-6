<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\SocialLogin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            echo "valido";
            return redirect()->intended('dashboard');
        }
    }*/

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

       // $credentials['email'] = $request->username;
       // $credentials['password'] = $request->password;

        //dd($credentials);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            echo "Valido";
            //return redirect()->intended('dashboard');
        } else{
            echo "inválido";
        }
    }

    public function redirectTo()
    {

        $role = Auth::user()->rol->key;

        switch ($role) {
            case 'admin':
                return '/dashboard/post';
                break;

            default:
                return "/";
                break;
        }
    }

    public function redirectToProvider($provider = 'twitter'){

        if(!config("services.$provider")) abort('404');

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider = 'twitter'){
        if(!config("services.$provider")) abort('404');
        
        $userSocialite = Socialite::driver($provider)->user();

        if($userSocial = SocialLogin::where('nick_email',$userSocialite->email)->orWhere('nick_email',$userSocialite->nickname)->first()){
            return $this->loginAndRedirect($userSocial->user);
        }else{
            // el usuario no existe

            $user = User::create([
                'name' => Str::of($userSocialite->name)->explode(' ')[0],
                'surname' => Str::of($userSocialite->name)->explode(' ')[1], // Andres Cruz VE
                'rol_id' => 2,
                'email' => $userSocialite->email ? $userSocialite->email : $userSocialite->nickname,
                'avatar' => $userSocialite->avatar,
                'password' => bcrypt(Str::random(10))
            ]);

            SocialLogin::create([
                'user_id' => $user->id,
                'provider'=> $provider,
                'nick_email' => $userSocialite->email ? $userSocialite->email : $userSocialite->nickname,
                'social_id' =>$userSocialite->id
            ]);

            return $this->loginAndRedirect($user);

        }



       // dd($user);
    }

    private function loginAndRedirect($user){
        Auth::login($user);
        return redirect()->to('/home');
    }

}
