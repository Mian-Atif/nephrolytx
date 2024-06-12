<?php

namespace App\Repositories\Backend\PracticeDoctors;

use DB;
use Carbon\Carbon;
use App\Models\PracticeDoctors\PracticeDoctor;
use App\Models\Person\Person;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PracticeDoctorRepository.
 */
class PracticeDoctorRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PracticeDoctor::class;

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
                config('module.practicedoctors.table').'.id',
                config('module.practicedoctors.table').'.created_at',
                config('module.practicedoctors.table').'.updated_at',
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
        if (PracticeDoctor::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.practicedoctors.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PracticeDoctor $practicedoctor
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PracticeDoctor $practicedoctor, array $input)
    {
    	if ($practicedoctor->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.practicedoctors.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PracticeDoctor $practicedoctor
     * @throws GeneralException
     * @return bool
     */
    public function delete(PracticeDoctor $practicedoctor)
    {
        if ($practicedoctor->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.practicedoctors.delete_error'));
    }

    public function  saveDoctors($input){

        $validatedData = $input->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'npi' => 'numeric|min:10',
            'taxonomy_code' => 'required',

        ]);

        $personArray = [
            'middle_name' =>$input['name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'npi' => $input['npi'],
            'taxonomy_code' => $input['taxonomy_code'],
        ];
        if ($person = Person::create($personArray)) {
            $doctorArray = [
                'person_id' =>$person->id,
                'practice_id' => $input['practice_id'],
            ];
            $doctor = PracticeDoctor::create($doctorArray);

            $doctor->locations()->attach($input['location_id'],[
                'practice_id'=>$input['practice_id']
            ]);
            return true;
        }
    }


    public function  updateDoctors($input){

        $personArray = [
            'middle_name' =>$input['name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'taxonomy_code' => $input['taxonomy_code'],
            'npi' => $input['npi'],
        ];

        $doctor = PracticeDoctor::find($input['doctor_id']);
        if ($person = $doctor->person->update($personArray)) {
//            $doctorArray = [
//                'person_id' =>$person->id,
//                'practice_id' => $input['practice_id'],
//            ];
//            $doctor = PracticeDoctor::create($doctorArray);
          /*  $doctor->locations()->sync($input['location_id'],[
                'practice_id'=>$input['practice_id']
            ]);*/
            return true;
        }
    }

    public function deleteDoctor($id){
        if(PracticeDoctor::where('id',$id)->delete()){
            return true;
        }

    }


}
