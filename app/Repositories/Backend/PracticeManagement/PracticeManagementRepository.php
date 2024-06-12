<?php

namespace App\Repositories\Backend\PracticeManagement;

use App\Models\Practice\Practice;
use DB;
use Carbon\Carbon;
use App\Models\PracticeManagement\PracticeManagement;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class PracticeManagementRepository.
 */
class PracticeManagementRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PracticeManagement::class;

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
                config('module.practicemanagements.table').'.id',
                config('module.practicemanagements.table').'.created_at',
                config('module.practicemanagements.table').'.updated_at',
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
        if (PracticeManagement::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.practicemanagements.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PracticeManagement $practicemanagement
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PracticeManagement $practicemanagement, array $input)
    {
    	if ($practicemanagement->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.practicemanagements.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PracticeManagement $practicemanagement
     * @throws GeneralException
     * @return bool
     */
    public function delete(PracticeManagement $practicemanagement)
    {
        if ($practicemanagement->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practicemanagements.delete_error'));
    }

    public  function updatepractice($input)
    {

        $validatedData = $input->validate([
            'practice_owner_email' => 'required',
            'practice_name' => 'required',
            'practice_type' => 'required',
            'email' => 'required',
        ]);
        //Input received from the request
        $practiceArray = [
            'name' => $input['practice_name'],
            'type' => $input['practice_type'],
            'email' => $input['email'],
//            'owner' => $input['owner'],
            'tax_id' => $input['tax_id'],

        ];

        $practice = Practice::find(Auth::user()->practice_id);
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

            $practiceDetail = $practice->detail->update($detailArray);


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
                'type' => 'practice',
            ]);
            return true;

        }
    }
}
