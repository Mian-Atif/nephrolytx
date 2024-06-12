<?php

namespace App\Http\Controllers\Backend\PerformanceReport;

use App\Models\PerformanceReport\PerformanceReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PerformanceReport\CreateResponse;
use App\Http\Responses\Backend\PerformanceReport\EditResponse;
use App\Repositories\Backend\PerformanceReport\PerformanceReportRepository;
use App\Http\Requests\Backend\PerformanceReport\ManagePerformanceReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * PerformanceReportsController
 */
class PerformanceReportsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PerformanceReportRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PerformanceReportRepository $repository ;
     */
    public function __construct(PerformanceReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\PerformanceReport\ManagePerformanceReportRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePerformanceReportRequest $request)
    {
        try {
            $title='Performance Report';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $performance = DB::select("CALL fr_performance_report($practice_id,$currentMonth,$currentDate)");
            $performanceReports = collect($performance)->groupBy('provider');
            return new ViewResponse('backend.performancereports.index', compact('performanceReports', 'currentMonth', 'currentDate', 'performance','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Performance Variance';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $performance = DB::select('call fr_performance_report(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $performanceReports = collect($performance)->groupBy('provider');
            $view = (string)view('backend.performancereports.partials.tableBody', compact('performanceReports', 'currentMonth', 'currentDate', 'performance'));
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
