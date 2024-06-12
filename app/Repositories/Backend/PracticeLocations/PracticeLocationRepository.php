<?php

namespace App\Repositories\Backend\PracticeLocations;

use App\Models\Addresses\Addresses;
use DB;
use Carbon\Carbon;
use App\Models\PracticeLocations\PracticeLocation;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PracticeLocationRepository.
 */
class PracticeLocationRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PracticeLocation::class;

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
                config('module.practicelocations.table').'.id',
                config('module.practicelocations.table').'.created_at',
                config('module.practicelocations.table').'.updated_at',
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
        if (PracticeLocation::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.practicelocations.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PracticeLocation $practicelocation
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PracticeLocation $practicelocation, array $input)
    {
    	if ($practicelocation->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.practicelocations.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PracticeLocation $practicelocation
     * @throws GeneralException
     * @return bool
     */
    public function delete(PracticeLocation $practicelocation)
    {
        if ($practicelocation->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practicelocations.delete_error'));
    }

    //save data for practice location
    public function  saveLocations($input){

        $validatedData = $input->validate([
            'location_name' => 'required',
        ]);
        $location = PracticeLocation::create([
            'location_name' => $input['location_name'],
            'location_map' => $input['location_map'],
            'practice_id' => $input['practice_id'],
            'npi' => $input['npi'],
            'email' => $input['email'],
            'phone' => $input['phone'],

        ]);

        $location->address()->create([
            'title' => $input['location_name'],
//            'email' => $input['email'],
            'address1' => $input['address1'],
            'address2' => $input['address2'],
            'city' => $input['city'],
            'state' => $input['state'],
            'zip' => $input['zip'],
        ]);

/*
        $location->doctors()->attach($input['doctor_id'],[
            'practice_id'=>$input['practice_id']
        ]);*/



        return true;
    }

    public function  updateLocation($input){

        $validatedData = $input->validate([
            'location_name' => 'required',
        ]);
        $location = PracticeLocation::find($input['location_id']);

        $location->update([
            'location_name' => $input['location_name'],
            'location_map' => $input['location_map'],
            'npi' => $input['npi'],
            'email' => $input['email'],
            'phone' => $input['phone'],

        ]);

        if (isset($location->address) && !is_null($location->address())){
            $location->address()->update([
                'title' => $input['location_name'],
                'address1' => $input['address1'],
                'address2' => $input['address2'],
                'city' => $input['city'],
                'state' => $input['state'],
                'zip' => $input['zip'],
            ]);
        }else{
            $location->address()->create([
                'title' => $input['location_name'],
                'address1' => $input['address1'],
                'address2' => $input['address2'],
                'city' => $input['city'],
                'state' => $input['state'],
                'zip' => $input['zip'],
            ]);
        }


    /*    $location->doctors()->sync($input['doctor_id'],[
            'practice_id'=>$input['practice_id']
        ]);*/
        return true;
    }


    //this will delete the practice location
    public  function deleteLocation($id){
        if(PracticeLocation::where('id',$id)->delete()){
            return true;
        }

    }

}
