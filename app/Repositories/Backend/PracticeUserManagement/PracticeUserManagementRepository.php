<?php

namespace App\Repositories\Backend\PracticeUserManagement;

use App\Mail\SendAccountCreatedEmail;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\PersonPracticePrivileges\PersonPracticePrivileges;
use DB;
use Carbon\Carbon;
use App\Models\PracticeUserManagement\PracticeUserManagement;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class PracticeUserManagementRepository.
 */
class PracticeUserManagementRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PracticeUserManagement::class;

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
                config('module.practiceusermanagements.table').'.id',
                config('module.practiceusermanagements.table').'.created_at',
                config('module.practiceusermanagements.table').'.updated_at',
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
        if (PracticeUserManagement::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.practiceusermanagements.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PracticeUserManagement $practiceusermanagement
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PracticeUserManagement $practiceusermanagement, array $input)
    {
    	if ($practiceusermanagement->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.practiceusermanagements.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PracticeUserManagement $practiceusermanagement
     * @throws GeneralException
     * @return bool
     */
    public function delete(PracticeUserManagement $practiceusermanagement)
    {
        if ($practiceusermanagement->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practiceusermanagements.delete_error'));
    }


    public  function savePracticeUser($input){


        $validatedData = $input->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
            'confirm_password' => 'min:12'
        ], [
            'password.regex' => 'At least one uppercase letter, one lowercase letter, one number and one special character.'
        ]);

        $person = Person::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'middle_name' => $input['middle_name'],
            'email' => $input['email'],
            'phone' => $input['phone']
        ]);
        $password = $input['password'];
        $user = $person->user()->create([
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'confirmed' => 1,
            'created_by' => Auth::user()->id,
            'person_id' => $person->id,
            'practice_id' =>Auth::user()->practice_id
        ]);

        $person->practiceUser()->create([
            'practice_id' =>Auth::user()->practice_id
        ]);

   /*     for ($i = 0; $i < count($input['location_id']); $i++)
        {
            PersonPracticePrivileges::create([
                'practice_id' => Auth::user()->practice_id,
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

    public  function changeUserStatus($id){

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
