<?php

namespace App\Http\Controllers;

use App\Http\Responses\ViewResponse;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('frontend.auth.twoFactor');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'two_factor_code' => 'integer|required',
            ]);

            $user = auth()->user();                

            if ($request->input('two_factor_code') == $user->two_factor_code) {
                if ($user->two_factor_expires_at->lt(now())) {
                    $user->resetTwoFactorCode();
                    auth()->logout();

                    return redirect()->route('login')
                        ->with(['error' => 'The two factor code has expired. Please login again.']);
                }
                
                $user->resetTwoFactorCode();
                session()->put('twoFactor', true);
                if (!is_null($user->roles()->where('name', 'Administrator')->first())) {
                    return redirect()->route('admin.dashboard');
                } elseif(!is_null($user->roles()->where('name', 'Practice')->first())) { 
                    return redirect()->route('admin.home');
                } elseif(!is_null($user->roles()->where('name', 'Billing Manager')->first())) {
                    return redirect()->route('admin.home');
                }elseif(!is_null($user->roles()->where('name', 'Practice User')->first())) {
                    return redirect()->route('admin.home');
                }
                else{
                    abort('401');
                }
            }

            return redirect()->back()
                ->with(['error' =>
                    'The two factor code you have entered does not match.']);
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            access()->logout();
            return redirect()->route('login')
                ->with(['error' => 'Something went wrong.']);
        }
    }

    public function resend()
    {
        try {
            $user = auth()->user();
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());
            return redirect()->back()->with(['success' => 'The two factor code has been sent again.']);
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            access()->logout();
            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }
    }
}