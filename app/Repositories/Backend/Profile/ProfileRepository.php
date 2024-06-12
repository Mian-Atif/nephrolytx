<?php

namespace App\Repositories\Backend\Profile;

use DB;
use Carbon\Carbon;
use App\Models\Profile\Profile;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileRepository.
 */
class ProfileRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Profile::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.profiles.table').'.id',
                config('module.profiles.table').'.created_at',
                config('module.profiles.table').'.updated_at',
            ]);
    }

    public  function  updateprofile($input)
    {

        $validatedData = $input->validate([
            'name' => 'required',
        ]);
        $user = Auth::user();
        $userArray = [
            'name' => $input['name'],
        ];
        if ($user->update($userArray)) {
            if($input['password']){

//                if (!Hash::check($input->password, $user->password))
//                {
//
//                    return redirect()->back()->withErrors(['password' => 'Use new password']);
//                }

                $input->validate([
                    'password' => 'required|min:12',
                ]);
                $user->update([
                    'password' => bcrypt($input['password']),
                ]);
            }
            else{
                return true;
            }
        }
    }

}
