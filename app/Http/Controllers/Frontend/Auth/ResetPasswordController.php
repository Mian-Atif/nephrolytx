<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedOut;
use App\Http\Controllers\Controller;
use App\Models\Access\User\PasswordHistory;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class ResetPasswordController.
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Where to redirect users after resetting password.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('frontend.index');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param string|null $token
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm($token = null)
    {
        if (!$token) {
            return redirect()->route('frontend.auth.password.reset');
        }

        $user = $this->user->findByPasswordResetToken($token);

        if ($user && app()->make('auth.password.broker')->tokenExists($user, $token)) {
            return view('frontend.auth.passwords.reset')
                ->withToken($token)
                ->withEmail($user->email);
        }
        return redirect()->route('frontend.auth.password.email')
            ->withFlashDanger(trans('exceptions.frontend.auth.password.reset_problem'));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'same:password|min:12'
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.',
        ];
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($request, $response)
    {
        $user = $request->user();
        // Checking current password
//        if (Hash::check($request->password, $user->password)) {
//            return redirect()->route('flash_route');
//        }

        //For Maintain password history
        $passwordhistories=PasswordHistory::select('password')->where('user_id',$request->user()->id)->get();

        foreach ($passwordhistories as $passwordhistory)
        {
        if(Hash::check($request->password, $passwordhistory->password))
        {
            return redirect()->route('flash_route');


        }
        }
//        $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
//        foreach($passwordHistories as $passwordHistory){
//            if (Hash::check($request->get('password'), $passwordHistory->password)) {
//                // The passwords matches
//                return redirect()->back()->with("flash_danger","Your new password can not be same as any of your recent passwords. Please choose a new password.");
//            }
//        }
        PasswordHistory::create([
            'user_id' => $request->user()->id,
            'password' => bcrypt($request->password)
        ]);
//
        return redirect()->route('flush_route');

    }

}
