<?php

namespace App\Http\Controllers\Backend\Profile;

use App\Models\Access\User\PasswordHistory;
use App\Models\Person\Person;
use App\Models\Profile\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Profile\CreateResponse;
use App\Http\Responses\Backend\Profile\EditResponse;
use App\Repositories\Backend\Profile\ProfileRepository;
use App\Http\Requests\Backend\Profile\ManageProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * ProfilesController
 */
class ProfilesController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProfileRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProfileRepository $repository ;
     */
    public function __construct(ProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\Profile\ManageProfileRequest $request
     * @return \App\Http\Responses\ViewResponse
     */


    public function index(ManageProfileRequest $request)
    {
        $user = Auth::user();
        return view('backend.profiles.index', compact('user'));
    }

    protected function rules()
    {
        return [
            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'same:password|min:12'

        ];
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:12|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'same:password|min:12'
        ], [
            'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.'
        ]);

        $user = $request->user();
        // Checking current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['flash_danger' => 'Current password is not correct']);
        }
//        // checking the new password is current password
//        if (Hash::check($request->password, $user->password)) {
//            return redirect()->back()->with(['flash_danger' => 'Current password is not availble for new password']);
//        }

        $passwordhistories = PasswordHistory::select('password')->where('user_id', $request->user()->id)->take('3')->orderby('id','desc')->get();

        foreach ($passwordhistories as $passwordhistory) {
            if (Hash::check($request->password, $passwordhistory->password)) {
                return redirect()->back()->withErrors(['password' => "You can't use old password"]);
            }
        }
        //For Maintain password history
        PasswordHistory::create([
            'user_id' => $request->user()->id,
            'password' => bcrypt($request->password)
        ]);
        $this->repository->updateprofile($request);

        return redirect()->route('flush_route');
    }

}
