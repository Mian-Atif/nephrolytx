<?php

namespace App\Http\Controllers\Backend\PatientDeductible;

use App\Models\PatientDeductible\PatientDeductible;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PatientDeductible\CreateResponse;
use App\Http\Responses\Backend\PatientDeductible\EditResponse;
use App\Repositories\Backend\PatientDeductible\PatientDeductibleRepository;
use App\Http\Requests\Backend\PatientDeductible\ManagePatientDeductibleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * PatientDeductiblesController
 */
class PatientDeductiblesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientDeductibleRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PatientDeductibleRepository $repository ;
     */
    public function __construct(PatientDeductibleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\PatientDeductible\ManagePatientDeductibleRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePatientDeductibleRequest $request)
    {
        try {
            $title='Patient Deductibles';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $patientDeductables = DB::select("CALL fr_patient_deductibles($practice_id,$currentMonth,$currentDate)");
            return new ViewResponse('backend.patientdeductibles.index', compact('patientDeductables', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Patient Deductibles';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $patientDeductables = DB::select('call fr_patient_deductibles(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $view = (string)view('backend.patientdeductibles.partials.tableBody', compact('patientDeductables', 'currentMonth', 'currentDate'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }


}
