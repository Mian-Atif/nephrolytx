<?php

namespace App\Repositories\Backend\CptCode;

use App\Models\Practice\Practice;
use DB;
use Carbon\Carbon;
use App\Models\CptCode\CptCode;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class CptCodeRepository.
 */
class CptCodeRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = CptCode::class;

    /**
     * @return mixed
     */

    public function getCptCode($id){
        $pratice=Practice::find($id);
        if(is_null($pratice)){
            $cpt=CptCode::get();
        }else{
//            $cpt=CptCode::whereNull('practice_id')->get();
//            $cpt=CptCode::where('practice_id',$id)->orWhereNull('practice_id')->get();
            $cpt= $pratice->getCptCode;

        }
        return $cpt;

    }



    public function getAll($order_by = 'sort', $sort = 'asc')
    {
        return $this->query()

            ->get();
    }
    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        $dataTableQuery= $this->query()
            ->select([
                config('module.cptcodes.table').'.id',
                config('module.cptcodes.table').'.created_at',
                config('module.cptcodes.table').'.updated_at',
            ]);
        return $dataTableQuery;
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
        if (CptCode::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.cptcodes.create_error'));
    }

    public  function addCptCode($input){
        $validatedData = $input->validate([
//            'cpt_code' => 'required|unique:cptcode_prices,cpt_code,'.Auth::user()->practice_id.',practice_id',
            'cpt_code' => 'required',
            'par_amount' => 'required',
        ]);
        $practiceId=Auth::user()->practice_id;
        $cptCode=$input['cpt_code'];
        $validate=CptCode::where('practice_id',$practiceId)->where('cpt_code',$cptCode)->get();//dd(count($validate)>0);
        if(count($validate) > 0){
//            dd(count($validate)>0);
            return response()->json(['status' => true,'message'=>'You Already take this CPT code']);
        }
        $cptInsuranceArray = [
            'practice_id' => $input['practice'],
            'cpt_code' => $input['cpt_code'],
            'par_amount' => $input['par_amount'],
            'state' => $input['state'],
        ];
        $cptCode=CptCode::create($cptInsuranceArray);
        $practiceId = $input['practice'];////Illuminate\Support\Facades\Auth::user()->practice_id;
        $cptCode->cptCodePrice()->associate($practiceId)->save();
        return response()->json(['status' => true,'message'=> 'CptCode Price Added Successfully !!']);

    }
    public  function addCptCodeDefault($input){

        $validatedData = $input->validate([
            'cpt_code' => 'required|unique:cptcode_prices,cpt_code',
            'par_amount' => 'required',
        ]);
        $cptInsuranceArray = [
            'cpt_code' => $input['cpt_code'],
            'par_amount' => $input['par_amount'],
            'state' => $input['state'],
        ];

        $cptCode=CptCode::create($cptInsuranceArray);

    }


}
