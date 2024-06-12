<?php

namespace App\Repositories\Backend\PracticeProfile;

use App\Http\Requests\Request;
use DB;
use Carbon\Carbon;
use App\Models\PracticeProfile\PracticeProfile;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class PracticeProfileRepository.
 */
class PracticeProfileRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PracticeProfile::class;

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
                config('module.practiceprofiles.table').'.id',
                config('module.practiceprofiles.table').'.created_at',
                config('module.practiceprofiles.table').'.updated_at',
            ]);
    }

    public  function  updateprofile($input)
    {

        $validatedData = $input->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);
        $user = Auth::user();
        $personArray = [
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'middle_name' => $input['middle_name'],
            'phone' => $input['phone'],
        ];
        if ($user->person->update($personArray)) {
         /*   if($input['password']){
                $user->update([
                    'password' => bcrypt($input['password']),
                ]);
            }
            else{*/
                return true;
//            }
        }
    }
    public function updatePassword($input){
        $validatedData = $input->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        if($input['password']){
            $user->update([
                'password' => bcrypt($input['password']),
            ]);
        }
    }



}
