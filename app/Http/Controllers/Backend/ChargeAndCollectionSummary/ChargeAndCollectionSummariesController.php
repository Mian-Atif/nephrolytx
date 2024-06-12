<?php

namespace App\Http\Controllers\Backend\ChargeAndCollectionSummary;

use App\Models\ChargeAndCollectionSummary\ChargeAndCollectionSummary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\ChargeAndCollectionSummary\CreateResponse;
use App\Http\Responses\Backend\ChargeAndCollectionSummary\EditResponse;
use App\Repositories\Backend\ChargeAndCollectionSummary\ChargeAndCollectionSummaryRepository;
use App\Http\Requests\Backend\ChargeAndCollectionSummary\ManageChargeAndCollectionSummaryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * ChargeAndCollectionSummariesController
 */
class ChargeAndCollectionSummariesController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChargeAndCollectionSummaryRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ChargeAndCollectionSummaryRepository $repository ;
     */
    public function __construct(ChargeAndCollectionSummaryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\ChargeAndCollectionSummary\ManageChargeAndCollectionSummaryRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageChargeAndCollectionSummaryRequest $request)
    {
        try {
            $title='Charges & Collections Summary';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $chargeCollectionSummaries = DB::select("CALL fr_charges_collection_summary($practice_id,$currentMonth,$currentDate)");
            return new ViewResponse('backend.chargeandcollectionsummaries.index', compact('chargeCollectionSummaries', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Charges & Collection Summary';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $chargeCollectionSummaries = DB::select('call fr_charges_collection_summary(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $view = (string)view('backend.chargeandcollectionsummaries.partials.tableBody', compact('chargeCollectionSummaries', 'currentMonth', 'currentDate'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);        }

    }
}
