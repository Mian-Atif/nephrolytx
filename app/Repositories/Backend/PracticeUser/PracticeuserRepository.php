<?php

namespace App\Repositories\Backend\PracticeUser;

use App\Mail\SendAccountCreatedEmail;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\PersonPracticePrivileges\PersonPracticePrivileges;
use DB;
use Carbon\Carbon;
use App\Models\PracticeUser\Practiceuser;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class PracticeuserRepository.
 */
class PracticeuserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Practiceuser::class;

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
                config('module.practiceusers.table').'.id',
                config('module.practiceusers.table').'.created_at',
                config('module.practiceusers.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (Practiceuser::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.practiceusers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Practiceuser $practiceuser
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Practiceuser $practiceuser, array $input)
    {
    	if ($practiceuser->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.practiceusers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Practiceuser $practiceuser
     * @throws GeneralException
     * @return bool
     */
    public function delete(Practiceuser $practiceuser)
    {
        if ($practiceuser->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practiceusers.delete_error'));
    }

    public  function savePracticeUser($input){


        $validatedData = $input->validate([
            'first_name' => 'required',
            'last_name' => 'required',
           // 'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|required_with:confirm_password|same:confirm_password|regex:"^(?=.*[a-z])(?=.*[A-Z]).{8,}$"',

            'confirm_password' => 'min:8'
        ]);

        $person = Person::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'middle_name' => $input['middle_name'],
            'email' => $input['email'],
            'phone' => $input['phone']
        ]);
        $password = $input['password'] ;

        $user = $person->user()->create([
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'confirmed' => 1,
            'created_by' => Auth::user()->id,
            'person_id' => $person->id,
            'practice_id' =>$input['practice_id']
        ]);

        $person->practiceUser()->create([
           'practice_id' =>$input['practice_id']
        ]);

   /*     for ($i = 0; $i < count($input['location_id']); $i++)
        {
            PersonPracticePrivileges::create([
                'practice_id' => $input['practice_id'],
                'location_id' => $input['location_id'][$i],
                'doctor_id' => $input['doctor_id'][$i],
                'person_id' => $person->id
            ]);
        }*/

        $roles = Role::where('name','Practice User')->select('id')->with('permissions')->get()->pluck('id');
        $permissions = Role::where('name','Practice User')->first()->permissions->pluck('id');

        //Attach new roles
        $user->attachRoles($roles);

        // Attach New Permissions
        $user->attachPermissions($permissions);
        $sendEmail = new SendAccountCreatedEmail($user,$password );
        Mail::to($user->email)->send($sendEmail);
    }

    public  function updateStatus($id){
        $user =  User::find($id);
        if($user->status == 1){
            $user->update([
                'status' =>0,
            ]);
        }else{

            $user->update([
                'status' =>1,
            ]);
        }
    }
}
