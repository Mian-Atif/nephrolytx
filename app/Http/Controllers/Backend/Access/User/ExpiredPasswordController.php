<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\PasswordExpiredRequest;
use App\Models\Access\User\PasswordHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExpiredPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.auth.passwords.expired-password');
    }


    public function postExpired(PasswordExpiredRequest $request)
    {
        $user = $request->user();
        // Checking current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['flash_danger' => 'Current password is not correct']);
        }

        $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
        foreach ($passwordHistories as $passwordHistory) {
            if (Hash::check($request->get('password'), $passwordHistory->password)) {
                // The passwords matches
                return redirect()->back()->with("flash_danger", "Your new password can not be same as any of your recent passwords. Please choose a new password.");
            }
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString()
        ]);


        //For Maintain password history
        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => bcrypt($request->password)
        ]);
        return redirect('admin/dashboard')->with(['flash_success' => 'Password changed successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
