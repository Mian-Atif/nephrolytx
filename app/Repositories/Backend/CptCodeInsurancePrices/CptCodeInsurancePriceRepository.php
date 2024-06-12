<?php

namespace App\Repositories\Backend\CptCodeInsurancePrices;

use App\Helpers\Auth\Auth;
use App\Mail\SendAccountCreatedEmail;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\BillingManager\BillingManager;
use App\Models\Person\Person;
use App\Models\Practice\Practice;
use DB;
use Carbon\Carbon;
use App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

/**
 * Class CptCodeInsurancePriceRepository.
 */
class CptCodeInsurancePriceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = CptCodeInsurancePrice::class;

    public function getCptCodeInsurance($id)
    {
        $pratice = Practice::find($id);

        if(is_null($pratice)){
            $cpt = CptCodeInsurancePrice::get();
        }else{
            $cpt=$pratice->getCptCodeInsurance;
        }
        return $cpt;
    }

    public function addCptCodeInsurance($input)
    {

        $validatedData = $input->validate([
            'insurance_name' => 'required',
            'cptcode' => 'required',
            'par_amount' => 'required',
            'state' => 'required',
        ]);

        $cptInsuranceArray = [
            'practice_id' => $input['practice'],
            'insurance_name' => $input['insurance_name'],
            'cptcode' => $input['cptcode'],
            'par_amount' => $input['par_amount'],
            'state' => $input['state'],

        ];

        $cptCode = CptCodeInsurancePrice::create($cptInsuranceArray);
        $practiceId = $input['practice'];//\Illuminate\Support\Facades\Auth::user()->practice_id;
        $cptCode->cptCodeInsurance()->associate($practiceId)->save();

    }

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
                config('module.cptcodeinsuranceprices.table') . '.id',
                config('module.cptcodeinsuranceprices.table') . '.created_at',
                config('module.cptcodeinsuranceprices.table') . '.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function create(array $input)
    {
        if (CptCodeInsurancePrice::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.cptcodeinsuranceprices.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param CptCodeInsurancePrice $cptcodeinsuranceprice
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update($cptcodeinsuranceprice,array $input)
    {

        $cptInsuranceArray = [
            'practice_id' => $request['practice'],
            'insurance_name' => $request['insurance_name'],
//            'cptcode' => $input['cptcode'],
            'par_amount' => $request['par_amount'],
            'state' => $request['state'],
        ];

        $practiceId=$request['practice'];
        $cptCode=$request['cptcode'];
        $insurance=$request['insurance_name'];
        $validate=CptCodeInsurancePrice::where('practice_id',$practiceId)->where('cptcode',$cptCode)->where('insurance_name',$insurance)->get();

        if(count($validate) > 0){
            return response()->json(['status' => false,'message'=>'You Already take this CPT code']);
        }
        $cptcodeinsuranceprice->update($cptInsuranceArray);
        if ($cptcodeinsuranceprice->update($cptInsuranceArray))
            return true;

        throw new GeneralException(trans('exceptions.backend.cptcodeinsuranceprices.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param CptCodeInsurancePrice $cptcodeinsuranceprice
     * @return bool
     * @throws GeneralException
     */
    public function delete(CptCodeInsurancePrice $cptcodeinsuranceprice)
    {
        if ($cptcodeinsuranceprice->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.cptcodeinsuranceprices.delete_error'));
    }
}
