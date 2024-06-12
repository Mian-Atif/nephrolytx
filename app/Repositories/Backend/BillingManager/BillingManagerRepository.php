<?php

namespace App\Repositories\Backend\BillingManager;

use DB;
use Carbon\Carbon;
use App\Mail\SendAccountCreatedEmail;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\PracticeProviderDetail;
use Auth;
use App\Models\Practice\Practice;
use App\Models\BillingManager\BillingManager;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Class BillingManagerRepository.
 */
class BillingManagerRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = BillingManager::class;

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
                config('module.billingmanagers.table').'.id',
                config('module.billingmanagers.table').'.created_at',
                config('module.billingmanagers.table').'.updated_at',
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
        if (BillingManager::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.billingmanagers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param BillingManager $billingmanager
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(BillingManager $billingmanager, array $input)
    {
    	if ($billingmanager->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.billingmanagers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param BillingManager $billingmanager
     * @throws GeneralException
     * @return bool
     */
    public function delete(BillingManager $billingmanager)
    {
        if ($billingmanager->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.billingmanagers.delete_error'));
    }

    public  function getBillingManager($id){

        $Practice = Practice::find($id);
        return  $Practice->getBillingManagers;
    }

    public  function addBillingManager($input){

        $validatedData = $input->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',

        ]);

        $personArray = [
            'first_name' =>$input['first_name'],
            'last_name' =>$input['last_name'],
            'middle_name' =>$input['middle_name'],
            'phone' => $input['phone'],
            'email' => $input['email'],

        ];

        if ($person = Person::create($personArray)) {
            $billingArray = [
                'person_id' =>$person->id,
                'practice_id' => Auth::user()->practice_id,
            ];
            BillingManager::create($billingArray);

            $password = "N".Str::random(4)."m".Str::random(4)."@".rand(0,9);
            //$password = rand(10000,90000);
            $user = User::create([
                'email' => $input['email'],
                'password' => bcrypt($password),
                'confirmed' => 1,
                'created_by' => Auth::user()->id,
                'person_id' => $person->id,
                'practice_id' => Auth::user()->practice_id,
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






}
