<?php

namespace App\Http\Controllers\Backend\AgingSummary;

use App\Models\AgingSummary\AgingSummary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\AgingSummary\CreateResponse;
use App\Http\Responses\Backend\AgingSummary\EditResponse;
use App\Repositories\Backend\AgingSummary\AgingSummaryRepository;
use App\Http\Requests\Backend\AgingSummary\ManageAgingSummaryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * AgingSummariesController
 */
class AgingSummariesController extends Controller
{
    /**
     * variable to store the repository object
     * @var AgingSummaryRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param AgingSummaryRepository $repository ;
     */
    public function __construct(AgingSummaryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\AgingSummary\ManageAgingSummaryRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageAgingSummaryRequest $request)
    {
        try {
            $title='AR Analysis By Insurance';
            $practice_id = Auth::user()->id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $agingSummaries = DB::select("CALL fr_aging_summary($practice_id,$currentMonth,$currentDate)");
            $grandTotal = collect($agingSummaries)->sum('charges');
            return new ViewResponse('backend.agingsummaries.index', compact('agingSummaries', 'currentMonth', 'currentDate', 'grandTotal','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='AR Analysis By Insurance';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $agingSummaries = DB::select('call fr_aging_summary(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $grandTotal = collect($agingSummaries)->sum('charges');
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            $view = (string)view('backend.agingsummaries.partials.tableBody', compact('agingSummaries', 'currentMonth', 'currentDate', 'grandTotal'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }


}
