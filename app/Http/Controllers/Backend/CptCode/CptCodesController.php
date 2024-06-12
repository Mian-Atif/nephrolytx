<?php

namespace App\Http\Controllers\Backend\CptCode;

use App\AnalyticData;
use App\Imports\AnalyticsDataImport;
use App\Imports\CptCodePrice;
use App\Models\Asset;
use App\Models\BillingManager\BillingManager;
use App\Models\CptCode\CptCode;
use App\Models\Practice\Practice;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\CptCode\CreateResponse;
use App\Http\Responses\Backend\CptCode\EditResponse;
use App\Repositories\Backend\CptCode\CptCodeRepository;
use App\Http\Requests\Backend\CptCode\ManageCptCodeRequest;
use App\Http\Requests\Backend\CptCode\CreateCptCodeRequest;
use App\Http\Requests\Backend\CptCode\StoreCptCodeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * CptCodesController
 */
class CptCodesController extends Controller
{
    /**
     * variable to store the repository object
     * @var CptCodeRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CptCodeRepository $repository ;
     */
    public function __construct(CptCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManageCptCodeRequest $request
     * @return ViewResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(ManageCptCodeRequest $request)
    {
        try {
            $practices = Practice::get();
            $user = Auth::user();
            $practiceId = Auth::user()->practice_id;
//            dd($practiceId);
                if (!is_null($user->roles()->where('name', 'Billing Manager')->first())) {
//                    dd($practices);

//                    if(isset($practices->id) && count($practices) > 0)
//                    {
                        $firstPracticeId = Practice::first()->id;

                        $cptCodes = CptCode::where('practice_id', $firstPracticeId)->get();
//                    }
                } else {
//                    dd('im in else');
                    $cptCodes = $this->repository->getCptCode($practiceId);
                }

                return new ViewResponse('backend.cptcodes.index', compact('cptCodes', 'practiceId', 'practices'));


//            else {
//                return new ViewResponse('backend.cptcodes.index');
//            }

        } catch
        (\Exception $e) {
            return back()->with('message','No Practice Availble for cptcode !');

        }
    }

    /**
     * @param CreateCptCodeRequest $request
     * @return CreateResponse
     */
    public function create(CreateCptCodeRequest $request)
    {
        return new CreateResponse('backend.cptcodes.create');
    }

    /**
     * @param StoreCptCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCptCodeRequest $request)
    {
//        dd('im her');
        try {
            $request->validate([
                'file' => 'required',
                'practice' => 'required',
            ]);
            set_time_limit(0);
            $extension = $request->file('file')->getClientOriginalExtension();
            $practice_id = $request->get('practice');

            if ($extension === 'txt' || $extension === 'csv') {
                $cptCodeData = CptCode::where('practice_id', $practice_id)->delete();

                Excel::import(new CptCodePrice($practice_id), $request->file('file'));
                return response()->json([
                    'status' => true,
                    'message' => 'You CSV file data successfully updated!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File not valid.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getcptcodePriceModal()
    {
        try {
            $user = Auth::user();
            $practices = Practice::get();
            $billingManager = $user->roles()->where('name', 'Billing Manager')->first();
            if ($billingManager != null) {
                $practices = BillingManager::where('person_id', $user->person_id)->with('practice')->get();
                $practices = $practices->pluck('practice');
            }
            $states = State::get();
            $popup = view('backend.cptcodes.partials.create-popup', compact('states', 'practices'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'There is no any Billing Manager Create One'
            ]);
        }
    }


    public function getCptAmount($cptId, $amount)
    {
        try {
            $cpt = CptCode::find($cptId);
            if ($amount != '') {
                $cpt->update(['par_amount' => $amount]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function save(Request $request)
    {
        try {
//            $this->repository->addCptCode($request);

            $validatedData = $request->validate([
//            'cpt_code' => 'required|unique:cptcode_prices,cpt_code,'.Auth::user()->practice_id.',practice_id',
                'cpt_code' => 'required',
                'par_amount' => 'required',
            ]);
            $practiceId = Auth::user()->practice_id;
            $cptCode = $request['cpt_code'];
            $validate = CptCode::where('practice_id', $practiceId)->where('cpt_code', $cptCode)->get();//dd(count($validate)>0);
            if (count($validate) > 0) {
                return response()->json(['status' => false, 'message' => 'You Already take this CPT code']);
            }
            $cptInsuranceArray = [
                'practice_id' => $request['practice'],
                'cpt_code' => $request['cpt_code'],
                'par_amount' => $request['par_amount'],
                'state' => $request['state'],
            ];
            $cptCode = CptCode::create($cptInsuranceArray);
            $practiceId = $request['practice'];////Illuminate\Support\Facades\Auth::user()->practice_id;
            $cptCode->cptCodePrice()->associate($practiceId)->save();
            return response()->json(['status' => true, 'message' => 'CptCode Price Added Successfully !!']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }

    }


    public function getcptcodeDefaultModal()
    {

        try {
            $states = State::get();
            $popup = view('backend.cptcodes.partials.create-popup-default', compact('states'))->render();

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


    public function cptDefaultStore(Request $request)
    {
        try {
//            $this->repository->addCptCodeDefault($request);
            $validatedData = $request->validate([
                'cpt_code' => 'required',
                'par_amount' => 'required',
            ]);
            $cptCode = $request['cpt_code'];
            $validate = CptCode::whereNull('practice_id')->where('cpt_code', $cptCode)->get();
            if (count($validate) > 0) {
                return response()->json(['status' => false, 'message' => 'You Already take this CPT code']);
            }
            $cptInsuranceArray = [
                'cpt_code' => $request['cpt_code'],
                'par_amount' => $request['par_amount'],
                'state' => $request['state'],
            ];

            $cptCode = CptCode::create($cptInsuranceArray);
            return response()->json(['status' => true, 'message' => 'CptCode Price Added Successfully !!']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }

    }


    public function destroy($id)
    {
        try {
            $cptcodeinsuranceprice = CptCode::find($id);
            $name = $cptcodeinsuranceprice->cpt_code;
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

    public function cptCodeDefault(ManageCptCodeRequest $request)
    {
        try {
            $cptCodes = CptCode::whereNull('practice_id')->get();
            return new ViewResponse('backend.cptcodes.default', compact('cptCodes'));
        } catch (\Exception $e) {
            return back();

        }
    }

    public function cptCodeFilter(Request $request)
    {

        try {

            $practices = Practice::get();
            $id = $request->get('practice');
            $cptCodes = CptCode::where('practice_id', $id)->get();
            $popup = view('backend.cptcodes.partials.tableRow', compact('cptCodes', 'practices'))->render();
//            return new ViewResponse('backend.cptcodes.partials.tableRow', compact('cptCodes', 'practices'));

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'view' => $popup
            ]);

        } catch (\Exception $e) {
            return back()->withFlashSuccess($e->getMessage());
        }
    }


}
