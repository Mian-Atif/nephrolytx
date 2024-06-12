<?php

namespace App\Repositories\Backend\Practice;

use App\Mail\SendAccountCreatedEmail;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\BillingManager\BillingManager;
use App\Models\Person\Person;
use App\Models\PracticeProviderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Practice\Practice;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Class PracticeRepository.
 */
class PracticeRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Practice::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        $dataTableQuery = $this->query()
            ->leftJoin('persons', 'persons.id', '=', 'practices.person_id')
            ->select ([
                config('module.practices.table').'.id',
                config('module.practices.table').'.name',
                config('module.practices.table').'.email',
                config('module.person.table').'.middle_name as owner',
                config('module.practices.table').'.type',
                config('module.practices.table').'.created_at',
                config('module.practices.table').'.updated_at'
            ]);
        return $dataTableQuery;

    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function createPractices($input)
    {

        $validatedData = $input->validate([
            'practice_owner_email' => 'required|email|unique:users,email',
        ]);
      try{
        //Input received from the request
        $practiceArray = [
            'name' =>$input['practice_name'],
            'type' => $input['practice_type'],

            'email' => $input['email'],
            'tax_id' => $input['tax_id'],

        ];

         if ($practice = Practice::create($practiceArray)) {
             $detailArray = [
                 'address_1' => $input['address_1'],
                 'address_2' => $input['address_2'],
                 'email' => $input['email'],
                 'city' => $input['city'],
                 'state' => $input['state'],
                 'phone' => $input['phone'],
                 'fax' => $input['fax'],
                 'website' => $input['website'],
                 'zip_code' => $input['zip'],
                 'npi' => $input['npi'],
                 'tax_id' => $input['tax_id'],
             ];

             //create user
             $practiceDetail=PracticeProviderDetail::create($detailArray);
             $person = Person::create([
                 'first_name' => $input['practice_owner_first_name'],
                 'last_name' => $input['practice_owner_last_name'],
                 'middle_name' => $input['practice_owner_middle_name'],
                 'email' => $input['practice_owner_email'],
                 'phone' => $input['practice_owner_phone']
             ]);

             // Adding person to practice
             $practice->person()->associate($person)->save();

             $password = "N".Str::random(4)."m".Str::random(4)."@".rand(0,9);

             $user = $person->user()->create([
                 'email' => $input['practice_owner_email'],
                 'password' => bcrypt($password),
                 'confirmed' => 1,
                 'created_by' => Auth::user()->id,
                 'person_id' => $person->id,
                 'practice_id' => $practice->id
             ]);



             $roles = Role::where('name','Practice')->select('id')->with('permissions')->get()->pluck('id');
             $permissions = Role::where('name','Practice')->first()->permissions->pluck('id');

             //Attach new roles
             $user->attachRoles($roles);

             // Attach New Permissions
             $user->attachPermissions($permissions);

             $practice->detail()->associate($practiceDetail)->save();

             $practice->specialities()->sync($input['speciality'], [
                 'type' =>'practice',
             ]);

             $sendEmail = new SendAccountCreatedEmail($user, $password);
             Mail::to($user->email)->send($sendEmail);
             return true;
         }
        throw new GeneralException(trans('exceptions.backend.practices.create_error'));

      }catch (\Exception $exception){
          dd($exception);
      }
    }





    /**
     * For updating the respective Model in storage
     *
     * @param Practice $practice
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Practice $practice, array $input)
    {

        //Input received from the request
        $practiceArray = [
            'name' =>$input['practice_name'],
            'type' => $input['practice_type'],
            'email' => $input['email'],
            'tax_id' => $input['tax_id'],

//            'owner' => $input['owner'],
        ];
        if ($practice->update($practiceArray)) {
            $detailArray = [
                'address_1' => $input['address_1'],
                'address_2' => $input['address_2'],
                'email' => $input['email'],
                'city' => $input['city'],
                'state' => $input['state'],
                'phone' => $input['phone'],
                'fax' => $input['fax'],
                'website' => $input['website'],
                'zip_code' => $input['zip'],
                'npi' => $input['npi'],

            ];

            $practiceDetail=$practice->detail->update($detailArray);


            $personArray = [
                'first_name' => $input['practice_owner_first_name'],
                'last_name' => $input['practice_owner_last_name'],
                'middle_name' => $input['practice_owner_middle_name'],
                'email' => $input['practice_owner_email'],
                'phone' => $input['practice_owner_phone']
            ];

            // Adding person to practice
            $practice->person()->update($personArray);


            $practice->specialities()->sync($input['speciality'], [
                'type' =>'practice',
            ]);
            return true;
        }


        throw new GeneralException(trans('exceptions.backend.practices.update_error'));
    }


    public  function saveBillingManager($input){

        $validatedData = $input->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
//            'address1' => 'required',
//            'address2' => 'required',
        ]);

        $personArray = [
            'first_name' =>$input['first_name'],
            'last_name' =>$input['last_name'],
            'middle_name' =>$input['middle_name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
//            'address1' => $input['address1'],
//            'address2' => $input['address2'],
        ];

        if ($person = Person::create($personArray)) {
            $billingArray = [
                'person_id' =>$person->id,
                'practice_id' => $input['practice_id'],
            ];
            BillingManager::create($billingArray);

            $password = rand(10000,90000);
            $user = User::create([
                'email' => $input['email'],
                'password' => bcrypt($password),
                'confirmed' => 1,
                'created_by' => Auth::user()->id,
                'person_id' => $person->id,
                'practice_id' => $input['practice_id'],
            ]);



            $roles = Role::where('name','Billing Manager')->select('id')->with('permissions')->get()->pluck('id');
            $permissions = Role::where('name','Practice')->first()->permissions->pluck('id');

            //Attach new roles
            $user->attachRoles($roles);

            // Attach New Permissions
            $user->attachPermissions($permissions);


            $sendEmail = new SendAccountCreatedEmail($user, $password);
            Mail::to($user->email)->send($sendEmail);
            return true;

        }


    }

    public  function getbillingUsers($id){
        $Practice = Practice::find($id);
        return  $Practice->getBillingManagers;
    }

    public  function getdoctorUsers($id){
        $Practice = Practice::find($id);
        return  $Practice->getDotorsdata;
    }

    public  function getownerUsers($id){
        $Practice = Practice::find($id);
        return  $Practice->person;
    }

    public  function users($id){
        $Practice = Practice::find($id);
        return  $Practice->users;
    }

    public  function deleteBillingUser($id){

        if(!is_null($id)){
            $person = Person::find($id);
            $person->user()->delete();
        }
    }

    public  function deleteDoctorUser($id){
        if(!is_null($id)){
            $person = Person::find($id);
            $person->user()->delete();
        }
    }



    /**
     * For deleting the respective model from storage
     *
     * @param Practice $practice
     * @throws GeneralException
     * @return bool
     */
    public function delete(Practice $practice)
    {

        if(!is_null($practice)) {
            if(!is_null($practice->detail)) {
                $practice->detail()->delete();
            }
            if(!is_null($practice->specialities)){
                $practice->specialities()->delete();
            }
            if(!is_null($practice->person) && !is_null($practice->person->user)){
                $practice->person->user()->delete();
            }
            if(!is_null($practice->person)){
                $practice->person()->delete();
            }
            $practice->delete();
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practices.delete_error'));
    }
    /**
     * @param  $input
     *
     * @return mixed
     */
    protected function createPracticeStub($input)
    {
    }

}
