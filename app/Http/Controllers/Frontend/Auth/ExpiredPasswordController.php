<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordExpiredRequest;
use App\Models\Access\User\PasswordHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExpiredPasswordController extends Controller
{

    public function index()
    {
        try {
            $email = \Illuminate\Support\Facades\Auth::user()->email;
            return view('frontend.auth.passwords.expired', compact('email'));
        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage());

        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'min:12'
        ], [
            'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.'
        ]);

        try {
            $user = $request->user();

            // Checking current password
            if (!Hash::check($request->current_password, $request->user()->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
            }
            $passwordhistories=PasswordHistory::select('password')->where('user_id',$request->user()->id)->get();

            foreach ($passwordhistories as $passwordhistory)
            {
                if(Hash::check($request->password, $passwordhistory->password))
                {
                    return redirect()->route('flash_route');


                }
            }

//            $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
//            foreach($passwordHistories as $passwordHistory){
//                if (Hash::check($request->get('password'), $passwordHistory->password)) {
//                    // The passwords matches
//                    return redirect()->back()->with("flash_danger","Your new password can not be same as any of your recent passwords. Please choose a new password.");
//                }
//            }
            //For Maintain password history
            PasswordHistory::create([
                'user_id' => $user->id,
                'password' => bcrypt($request->password)
            ]);

            $request->user()->update([
                'password' => bcrypt($request->password),
                'password_changed_at' => Carbon::now()->toDateTimeString()
            ]);
            return redirect()->back()->with(['status' => 'Password changed successfully']);

        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage());

        }


    }
    }
