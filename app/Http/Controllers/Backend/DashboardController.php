<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\PracticeDoctors\PracticeDoctor;
use App\Models\Provider\Provider;
use App\Models\Settings\Setting;
use App\Models\Practice\Practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
       // return redirect()->guest(route('login'));
        /* these are for admin
   $totalStats =
       \DB::select(DB::raw('SELECT func_activePatients(1) AS activePatients ,func_CKD_Patients(1) AS CKDPatients,func_ESRD_Patients(1) as ESRDPatients,func_newPatients(1)AS newPatients'));*/
        $countPractice = Practice::count();
        $countUser = User::count();
        $countPerson = Person::count();
        $countProvider = PracticeDoctor::count();
        return view('backend.dashboard', compact('countPractice', 'countUser', 'countPerson', 'countProvider'));

    }

    /**
     * Used to display form for edit profile.
     *
     * @return view
     */
    public function editProfile(Request $request)
    {
        return view('backend.access.users.profile-edit')
            ->withLoggedInUser(access()->user());
    }

    /**
     * Used to update profile.
     *
     * @return view
     */
    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $userId = access()->user()->id;
        $user = User::find($userId);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->updated_by = access()->user()->id;

        if ($user->save()) {
            return redirect()->route('admin.profile.edit')
                ->withFlashSuccess(trans('labels.backend.profile_updated'));
        }
    }

    /**
     * This function is used to get permissions details by role.
     *
     * @param Request $request
     */
    public function getPermissionByRole(Request $request)
    {
        if ($request->ajax()) {
            $role_id = $request->get('role_id');
            $rsRolePermissions = Role::where('id', $role_id)->first();
            $rolePermissions = $rsRolePermissions->permissions->pluck('display_name', 'id')->all();
            $permissions = Permission::pluck('display_name', 'id')->all();
            ksort($rolePermissions);
            ksort($permissions);
            $results['permissions'] = $permissions;
            $results['rolePermissions'] = $rolePermissions;
            $results['allPermissions'] = $rsRolePermissions->all;
            echo json_encode($results);
            die;
        }
    }
}
