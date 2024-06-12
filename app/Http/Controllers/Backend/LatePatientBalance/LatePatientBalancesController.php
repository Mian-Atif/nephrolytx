<?php

namespace App\Http\Controllers\Backend\LatePatientBalance;

use App\Models\LatePatientBalance\LatePatientBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\LatePatientBalance\CreateResponse;
use App\Http\Responses\Backend\LatePatientBalance\EditResponse;
use App\Repositories\Backend\LatePatientBalance\LatePatientBalanceRepository;
use App\Http\Requests\Backend\LatePatientBalance\ManageLatePatientBalanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * LatePatientBalancesController
 */
class LatePatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var LatePatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param LatePatientBalanceRepository $repository;
     */
    public function __construct(LatePatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\LatePatientBalance\ManageLatePatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index()
    {
        try {
            $practice_id = Auth::user()->practice_id;

            $servicesAnalysis = DB::select("call service_analysis($practice_id,'','','','')");

            $servicesAnalysis = collect($servicesAnalysis)->groupBy('monthNme');
            return new ViewResponse('backend.latepatientbalances.index', compact('servicesAnalysis'));
        }catch (\Exception $e) {
            dd($e);
                return back();
            }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $payer= $request->get('payer');
            $provider = $request->get('provider');
            $location = $request->get('location');
            $servicesAnalyses = DB::select('CALL service_analysis(?,?,?,?,?)', array($practice_id, $location, $provider,$payer, ''));
            $servicesAnalysis = collect($servicesAnalyses)->groupBy('monthNme');
            $view = (string)view('backend.latepatientbalances.partials.tableBody',  compact('servicesAnalysis'));

            $activePatientStats=DB::select('CALL active_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $newPatientStats =DB::select('CALL new_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $esrdStats =DB::select('CALL ESRD_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $nonEsrdStats =DB::select('CALL nonESRD_patient_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $stat = (string) view('backend.partials.statsRow', compact('activePatientStats','newPatientStats','esrdStats','nonEsrdStats'
            ));
            return response()->json(['status' => true, 'view' => $view,'stat'=>$stat]);
        }catch (\Exception $e) {
            return back();
        }

    }


}
