<?php

namespace App\Http\Controllers\Backend\PatientPayments;

use App\Models\PatientPayments\PatientPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PatientPayments\CreateResponse;
use App\Http\Responses\Backend\PatientPayments\EditResponse;
use App\Repositories\Backend\PatientPayments\PatientPaymentRepository;
use App\Http\Requests\Backend\PatientPayments\ManagePatientPaymentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * PatientPaymentsController
 */
class PatientPaymentsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientPaymentRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PatientPaymentRepository $repository ;
     */
    public function __construct(PatientPaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManagePatientPaymentRequest $request
     * @return ViewResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(ManagePatientPaymentRequest $request)
    {
        try {
            $title='Patient Payments Report';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $patientPayments = DB::select("CALL fr_patient_payments($practice_id,$currentMonth,$currentDate)");
            return new ViewResponse('backend.patientpayments.index', compact('patientPayments', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Patient Payments Report';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $patientPayments = DB::select('call fr_patient_payments(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $view = (string)view('backend.patientpayments.partials.tableBody', compact('patientPayments', 'currentMonth', 'currentDate'));
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
