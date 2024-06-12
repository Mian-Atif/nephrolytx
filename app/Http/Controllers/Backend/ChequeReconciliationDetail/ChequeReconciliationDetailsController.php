<?php

namespace App\Http\Controllers\Backend\ChequeReconciliationDetail;

use App\Models\ChequeReconciliationDetail\ChequeReconciliationDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\ChequeReconciliationDetail\CreateResponse;
use App\Http\Responses\Backend\ChequeReconciliationDetail\EditResponse;
use App\Repositories\Backend\ChequeReconciliationDetail\ChequeReconciliationDetailRepository;
use App\Http\Requests\Backend\ChequeReconciliationDetail\ManageChequeReconciliationDetailRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * ChequeReconciliationDetailsController
 */
class ChequeReconciliationDetailsController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChequeReconciliationDetailRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ChequeReconciliationDetailRepository $repository ;
     */
    public function __construct(ChequeReconciliationDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\ChequeReconciliationDetail\ManageChequeReconciliationDetailRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageChequeReconciliationDetailRequest $request)
    {
        try {
            $title='Checks Reconciliation Detail';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $chequeReconciliationDetails = DB::select("CALL fr_cheque_reconciliation_detail($practice_id,$currentMonth,$currentDate)");
            return new ViewResponse('backend.chequereconciliationdetails.index', compact('chequeReconciliationDetails', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Checks Reconciliation Detail';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $chequeReconciliationDetails = DB::select('call fr_cheque_reconciliation_detail(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $view = (string)view('backend.chequereconciliationdetails.partials.tableBody', compact('chequeReconciliationDetails', 'currentMonth', 'currentDate'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);
        } catch (\Exception $e) {
            return back();
        }

    }

}
