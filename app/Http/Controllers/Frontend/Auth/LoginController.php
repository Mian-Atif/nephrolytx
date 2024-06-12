<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Helpers\Frontend\Auth\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Access\User\PasswordHistory;

//use App\Http\Utilities\NotificationIos;
//use App\Http\Utilities\PushNotification;
use App\Models\Access\User\User;
use App\Notifications\TwoFactorCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 5;
    protected $decayMinutes = 10;
    /**
     * @var \App\Http\Utilities\PushNotification
     */
    //    protected $notification;
    //
    //    /**
    //     * @param NotificationIos $notification
    //     */
    //    public function __construct(PushNotification $notification)
    //    {
    //        $this->notification = $notification;
    //    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {

        if (!is_null(access()->user()->roles()->where('name', 'Administrator')->first())) {
            return route('admin.dashboard');
        } elseif (!is_null(access()->user()->roles()->where('name', 'Practice')->first())) {
            return route('admin.home');
        } elseif (!is_null(access()->user()->roles()->where('name', 'Practice User')->first())) {
            return route('admin.home');
        } elseif (!is_null(access()->user()->roles()->where('name', 'Billing Manager')->first())) {
            return route('admin.home');
        }
    }

    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required', //|string|min:12|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/
        ], [
            'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.'
        ]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if ($user = \Illuminate\Support\Facades\Auth::user()) {
            return redirect()->back();
        }
        return view('frontend.auth.login')
            ->withSocialiteLinks((new Socialite())->getSocialLinks());
    }

    /**
     * @param Request $request
     * @param $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     *
     */
    protected function authenticated(Request $request, $user)
    {
        $password = $request->get('password');
        \Illuminate\Support\Facades\Auth::logoutOtherDevices($password);


        /*
         * Check to see if the users account is confirmed and active
         */
        if (!$user->isConfirmed()) {

            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.resend', ['user_id' => $user->id]), true);
        } elseif (!$user->isActive()) {

            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.deactivated'));
        }

        //        event(new UserLoggedIn($user));



        // if (\Illuminate\Support\Facades\Auth::check()) {
        //     // The user is logged in...
        //     dd("Logged in");
        //     die;
        // }else{
        //     dd("Not Logged in");
        //     die;
        // }

        // $user->generateTwoFactorCode();
        // $user->notify(new TwoFactorCode());
        // Session::put('user', $user);

        $user->resetTwoFactorCode();
        session()->put('twoFactor', true);
        //dd($user->roles()->where('name', 'Practice')->first());
        if (!is_null($user->roles()->where('name', 'Administrator')->first())) {
            return redirect()->route('admin.dashboard');
        } elseif (!is_null($user->roles()->where('name', 'Practice')->first())) {
            //            dd('im here');
            return redirect()->route('admin.practiceDashboard');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        /*
         * Boilerplate needed logic
         */

        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            // dd(app('session')->has(config('access.socialite_session_name')));
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Remove any session data from backend
         */
        app()->make(Auth::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($this->guard()->user()));

        /*
         * Laravel specific logic
         */
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        //If for some reason route is getting hit without someone already logged in
        if (!access()->user()) {
            return redirect()->route('frontend.auth.login');
        }

        //If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            //Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            //Re-login admin
            access()->loginUsingId((int)$admin_id);

            //Redirect to backend user page
            return redirect()->route('admin.access.user.index');
        } else {
            app()->make(Auth::class)->flushTempSession();

            //Otherwise logout and redirect to login
            access()->logout();

            return redirect()->route('frontend.auth.login');
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required',
                'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
                'confirm_password' => 'min:12'
            ], [
                'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator);
            }


            $user = User::where('confirmation_code', $request->get('token'))->first();

            if (is_null($user)) {
                return abort(401);
            }

            $user->fill([
                'password' => bcrypt($request->password),
                'confirmation_code' => null,
                'confirmed' => 1,
                'status' => 1,
            ])->update();


            //For Maintain password history
            PasswordHistory::create([
                'user_id' => $user->id,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('flush_route');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->intended('login');
        }
    }
}
