<?php

namespace App\Http\Controllers\Backend\ChargeDetailReport;

use App\Models\ChargeDetailReport\ChargeDetailReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\ChargeDetailReport\CreateResponse;
use App\Http\Responses\Backend\ChargeDetailReport\EditResponse;
use App\Repositories\Backend\ChargeDetailReport\ChargeDetailReportRepository;
use App\Http\Requests\Backend\ChargeDetailReport\ManageChargeDetailReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Psr7\str;

/**
 * ChargeDetailReportsController
 */
class ChargeDetailReportsController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChargeDetailReportRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ChargeDetailReportRepository $repository ;
     */
    public function __construct(ChargeDetailReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\ChargeDetailReport\ManageChargeDetailReportRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageChargeDetailReportRequest $request)
    {
        try {
            $title='Charges Detail Report';
            $practice_id = Auth::user()->practice_id;

            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            //Query format
//        $chargeDetails=DB::select("CALL fr_charges_detail($practice_id,'7/01/2020','7/24/2020')");

            $chargeDetails = DB::select("CALL fr_charges_detail($practice_id,$currentMonth,$currentDate)");

            return new ViewResponse('backend.chargedetailreports.index', compact('chargeDetails', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Charges Detail Report';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $chargeDetails = DB::select('call fr_charges_detail(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $view = (string)view('backend.chargedetailreports.partials.tableBody', compact('chargeDetails', 'currentMonth', 'currentDate','title'));
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
