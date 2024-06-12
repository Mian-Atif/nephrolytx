<?php

namespace App\Http\Controllers\Backend\TransactionAnalysis;

use App\Models\TransactionAnalysis\TransactionAnalysi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\TransactionAnalysis\CreateResponse;
use App\Http\Responses\Backend\TransactionAnalysis\EditResponse;
use App\Repositories\Backend\TransactionAnalysis\TransactionAnalysiRepository;
use App\Http\Requests\Backend\TransactionAnalysis\ManageTransactionAnalysiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * TransactionAnalysisController
 */
class TransactionAnalysisController extends Controller
{
    /**
     * variable to store the repository object
     * @var TransactionAnalysiRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TransactionAnalysiRepository $repository ;
     */
    public function __construct(TransactionAnalysiRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\TransactionAnalysis\ManageTransactionAnalysiRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function store(Request $request)
    {
        try {
            $title='Transaction Analysis';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $transactions = DB::select('call fr_transaction_analysis(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $transactionAnalyses = collect($transactions)->groupBy('provider');
            $view = (string)view('backend.transactionanalyses.partials.tableBody', compact('transactionAnalyses', 'currentMonth', 'currentDate'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function index(ManageTransactionAnalysiRequest $request)
    {
        try {
            $title='Transaction Analysis';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            //Query format
//        $transactions = DB::select("CALL fr_transaction_analysis($practice_id,'7/01/2020','7/24/2020')");
            $transactions = DB::select("CALL fr_transaction_analysis($practice_id,$currentMonth,$currentDate)");
            $transactionAnalyses = collect($transactions)->groupBy('provider');
            return new ViewResponse('backend.transactionanalyses.index', compact('title','transactionAnalyses', 'currentMonth', 'currentDate'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

}
