<?php

namespace App\Http\Controllers\Backend\CptCodeInsurancePrices;

use App\Models\BillingManager\BillingManager;
use App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice;
use App\Models\Practice\Practice;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\CptCodeInsurancePrices\CreateResponse;
use App\Http\Responses\Backend\CptCodeInsurancePrices\EditResponse;
use App\Repositories\Backend\CptCodeInsurancePrices\CptCodeInsurancePriceRepository;
use App\Http\Requests\Backend\CptCodeInsurancePrices\ManageCptCodeInsurancePriceRequest;
use App\Http\Requests\Backend\CptCodeInsurancePrices\CreateCptCodeInsurancePriceRequest;
use App\Http\Requests\Backend\CptCodeInsurancePrices\StoreCptCodeInsurancePriceRequest;
use App\Http\Requests\Backend\CptCodeInsurancePrices\EditCptCodeInsurancePriceRequest;
use App\Http\Requests\Backend\CptCodeInsurancePrices\UpdateCptCodeInsurancePriceRequest;
use App\Http\Requests\Backend\CptCodeInsurancePrices\DeleteCptCodeInsurancePriceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * CptCodeInsurancePricesController
 */
class CptCodeInsurancePricesController extends Controller
{
    /**
     * variable to store the repository object
     * @var CptCodeInsurancePriceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CptCodeInsurancePriceRepository $repository ;
     */
    public function __construct(CptCodeInsurancePriceRepository $repository)
    {
        $this->repository = $repository;

    }

    /**
     * @param ManageCptCodeInsurancePriceRequest $request
     * @return ViewResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(ManageCptCodeInsurancePriceRequest $request)
    {
        try {
            $practices = Practice::get();
            $user = Auth::user();
            $practiceId = Auth::user()->practice_id;
            if (!is_null($practiceId))
            {
                if (!is_null($user->roles()->where('name', 'Administrator')->first())) {
                    $firstPracticeId = Practice::first()->id;
                    $cptCodes = CptCodeInsurancePrice::where('practice_id', $firstPracticeId)->get();

                } else {
                    $cptCodes = $this->repository->getCptCodeInsurance($practiceId);
                }

            return new ViewResponse('backend.cptcodeinsuranceprices.index', compact('cptCodes', 'practiceId', 'practices'));
        } else{
                return new ViewResponse('backend.cptcodeinsuranceprices.index');
            }

        } catch (\Exception $e) {
            dd($e);
            return back();
        }
    }

    /**
     * @param CreateCptCodeInsurancePriceRequest $request
     * @return CreateResponse
     */
    public function create(CreateCptCodeInsurancePriceRequest $request)
    {
        return new CreateResponse('backend.cptcodeinsuranceprices.create');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getcptcodeInsuranceModal()
    {
        try {
            $user = Auth::user();
            $practices=Practice::get();
            $practice_id = $user->practice_id;
            $payers=DB::table('practice_payers')
                ->where('practice_id',$practice_id)
                ->get();
            $states = State::get();
            $popup = view('backend.cptcodeinsuranceprices.partials.create-popup', compact('states','payers','practices'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCommitModal($id)
    {
        try {
            $cptCode = CptCodeInsurancePrice::find($id);
            $user = Auth::user();
            $practices=Practice::get();
            if(!is_null($user->roles()->where('name', 'Billing Manager')->first())){
                $practices=BillingManager::where('person_id', $user->person_id)->with('practice')->get();
                $practices=$practices->pluck('practice');
            }

            $states = State::get();
            if (is_null($cptCode)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Listing not found!'
                ]);
            }

            $user = Auth::user();
            $practice_id = $user->practice_id;
            $payers=DB::table('practice_payers')
                ->where('practice_id',$practice_id)
                ->get();
            $popup = view('backend.cptcodeinsuranceprices.partials.create-popup', compact('practices','cptCode', 'states','payers'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

//    public function store(StoreCptCodeInsurancePriceRequest $request)
    public function store(Request $request)
    {
        try {
//            $this->repository->addCptCodeInsurance($request);


            $validatedData = $request->validate([
                'insurance_name' => 'required',
                'cptcode' => 'required',
                'par_amount' => 'required',
                'state' => 'required',
            ]);
            $practiceId=$request['practice'];
            $cptCode=$request['cptcode'];
            $insurance=$request['insurance_name'];
            $validate=CptCodeInsurancePrice::where('practice_id',$practiceId)->where('cptcode',$cptCode)->where('insurance_name',$insurance)->get();

            if(count($validate) > 0){
                return response()->json(['status' => false,'message'=>'You Already take this CPT code']);
            }
            $cptInsuranceArray = [
                'practice_id' => $request['practice'],
                'insurance_name' => $request['insurance_name'],
                'cptcode' => $request['cptcode'],
                'par_amount' => $request['par_amount'],
                'state' => $request['state'],

            ];

            $cptCode = CptCodeInsurancePrice::create($cptInsuranceArray);
            $practiceId = $request['practice'];//\Illuminate\Support\Facades\Auth::user()->practice_id;
            $cptCode->cptCodeInsurance()->associate($practiceId)->save();
            return response()->json(['status' => true,'message'=> 'CptCode Payer Added Successfully !']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
        }

    /**
     * @param CptCodeInsurancePrice $cptcodeinsuranceprice
     * @param EditCptCodeInsurancePriceRequest $request
     * @return EditResponse
     */
    public function edit(CptCodeInsurancePrice $cptcodeinsuranceprice, EditCptCodeInsurancePriceRequest $request)
    {
        return new EditResponse($cptcodeinsuranceprice);
    }
    /**
     * @param $id
     * @param UpdateCptCodeInsurancePriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    //Due to some issue i can't get data form Cpt code insurea nce model,thats'why i used here direct $id
    public function update($id, UpdateCptCodeInsurancePriceRequest $request)
    {
        try{
        $cptcodeinsuranceprice = CptCodeInsurancePrice::find($id);
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
//        $this->repository->update($cptcodeinsuranceprice, $input);
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
 /*           $validate=CptCodeInsurancePrice::where('practice_id','!=',$practiceId)->where('insurance_name',$insurance)->get();

            if(count($validate) > 0){
                return response()->json(['status' => false,'message'=>'You Already take this CPT code']);
            }*/
            $cptcodeinsuranceprice->update($cptInsuranceArray);
        //return with successfull message
            return response()->json(['status' => true,'message'=> 'CptCode Payer Price Updated Successfully !']);

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $cptcodeinsuranceprice = CptCodeInsurancePrice::find($id);
            $name = $cptcodeinsuranceprice->insurance_name;
            if (!is_null($cptcodeinsuranceprice)) {
                $cptcodeinsuranceprice->delete();
                return response()->json([
                    'status' => true,
                    'message' => $name . ' deleted successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function cptCodePayerFilter(Request $request)
    {

        try {

            $practices = Practice::get();
            $id=$request->get('practice');
            $cptCodes = CptCodeInsurancePrice::where('practice_id', $id)->get();
            $popup = view('backend.cptcodeinsuranceprices.partials.tableRow', compact('cptCodes', 'practices'))->render();
//            return new ViewResponse('backend.cptcodes.partials.tableRow', compact('cptCodes', 'practices'));

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'view' => $popup
            ]);

        }  catch (\Exception $e) {
            return back()->withFlashSuccess($e->getMessage());
        }
    }
    public function cptCodePayerPractice($id)
        {
    $payers=DB::table('practice_payers')
        ->where('practice_id',$id)
        ->pluck("payer_name");
return response()->json($payers);
}

}
