<?php

namespace App\Http\Controllers\Backend\AnalysisReport;

use App\Models\AnalysisReport\AnalysisReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
//use App\Http\Responses\Backend\AnalysisReport\CreateResponse;
//use App\Http\Responses\Backend\AnalysisReport\EditResponse;
use App\Repositories\Backend\AnalysisReport\AnalysisReportRepository;
use App\Http\Requests\Backend\AnalysisReport\ManageAnalysisReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * AnalysisReportsController
 */
class AnalysisReportsController extends Controller
{
    /**
     * variable to store the repository object
     * @var AnalysisReportRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param AnalysisReportRepository $repository;
     */
    public function __construct(AnalysisReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManageAnalysisReportRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(ManageAnalysisReportRequest $request)
    {

        try {

            $practice_id = Auth::user()->practice_id;

            $cptLists = DB::select("call service_analysis_cpt_wise($practice_id,'','','','')");
//           dd($cptLists);
            return view('backend.analysisreports.index', compact('cptLists'));
        }catch (\Exception $e) {
            dd($e);
                return back();
            }
        }

    public function store(Request $request)
    {
        try{
        $user = Auth::user();
        $practice_id = $user->practice_id;
        $provider = $request->get('provider');
        $location = $request->get('location');
            $payer= $request->get('payer');
            $cptLists = DB::select('CALL service_analysis_cpt_wise(?,?,?,?,?)', array($practice_id, $location, $provider,$payer, ''));
            $view = (string)view('backend.analysisreports.partials.tableBody', compact('cptLists'));

            $activePatientStats=DB::select('CALL active_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $newPatientStats =DB::select('CALL new_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $esrdStats =DB::select('CALL ESRD_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $nonEsrdStats =DB::select('CALL nonESRD_patient_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $stat = (string) view('backend.partials.statsRow', compact('activePatientStats','newPatientStats','esrdStats','nonEsrdStats'
            ));
            return response()->json(['status' => true, 'view' => $view,'stat'=>$stat]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }


}
