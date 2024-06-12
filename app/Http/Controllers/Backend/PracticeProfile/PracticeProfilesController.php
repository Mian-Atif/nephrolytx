<?php

namespace App\Http\Controllers\Backend\PracticeProfile;

use App\Http\Requests\PasswordExpiredRequest;
use App\Models\Access\User\PasswordHistory;
use App\Models\Access\User\User;
use App\Models\PracticeProfile\PracticeProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PracticeProfile\CreateResponse;
use App\Http\Responses\Backend\PracticeProfile\EditResponse;
use App\Repositories\Backend\PracticeProfile\PracticeProfileRepository;
use App\Http\Requests\Backend\PracticeProfile\ManagePracticeProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * PracticeProfilesController
 */
class PracticeProfilesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeProfileRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeProfileRepository $repository ;
     */
    public function __construct(PracticeProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\PracticeProfile\ManagePracticeProfileRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeProfileRequest $request)
    {
        $user = Auth::user();
        return view('backend.practiceprofiles.index', compact('user'));
    }

    public function updateprofile(Request $request)
    {

        if (Hash::check($request->password, $request->user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Use new password']);
        }
        $this->repository->updateprofile($request);
        return back()->with('message', 'Profile Updated Successfully');
    }

    public function updatePassword(Request $request)
    {


        $request->validate([
            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'min:12'
        ], [
            'password.regex' => 'Minimum 12 characters, at least one uppercase letter, one lowercase letter, one number and one special character'
        ]);
        try {
                //this check the current password is correct or not
            if (!Hash::check($request->current_password, $request->user()->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
            }
//            //this check the password new password is already in use of this user
//            if (Hash::check($request->password, $request->user()->password)) {
//                return redirect()->back()->withErrors(['password' => 'Use new password']);
//            }
            //this check the new password is your old password
            $passwordhistories = PasswordHistory::select('password')->where('user_id', $request->user()->id)->get();

            foreach ($passwordhistories as $passwordhistory) {
                if (Hash::check($request->password, $passwordhistory->password)) {
                    return redirect()->back()->withErrors(['password' => "You can't use old password"]);
                }
            }
//            $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
//            foreach($passwordHistories as $passwordHistory){
//                if (Hash::check($request->get('password'), $passwordHistory->password)) {
//                    // The passwords matches
//                    return redirect()->back()->with("flash_danger","Your new password can not be same as any of your recent passwords. Please choose a new password.");
//                }
//            }


            $request->user()->update([
                'password' => bcrypt($request->password),
                'password_changed_at' => Carbon::now()->toDateTimeString()
            ]);

            //For Maintain password history
            PasswordHistory::create([
                'user_id' => $request->user()->id,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('flush_route');

        } catch (\Exception $e) {
            return back()->with(['message', $e->getMessage(), 'passwordStatus' => true]);

        }
    }

}
