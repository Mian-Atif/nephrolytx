<?php

namespace App\Http\Controllers\Backend\EsrdPatientBalance;

use App\Models\EsrdPatientBalance\ESRDPatientBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\EsrdPatientBalance\CreateResponse;
use App\Http\Responses\Backend\EsrdPatientBalance\EditResponse;
use App\Repositories\Backend\EsrdPatientBalance\ESRDPatientBalanceRepository;
use App\Http\Requests\Backend\EsrdPatientBalance\ManageESRDPatientBalanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * ESRDPatientBalancesController
 */
class ESRDPatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var ESRDPatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ESRDPatientBalanceRepository $repository;
     */
    public function __construct(ESRDPatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\EsrdPatientBalance\ManageESRDPatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageESRDPatientBalanceRequest $request)
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $totalStats =
                DB::select(DB::raw("SELECT func_activePatients($practice_id) AS activePatients ,func_CKD_Patients($practice_id) AS CKDPatients,func_ESRD_Patients($practice_id) as ESRDPatients,func_newPatients($practice_id)AS newPatients"));

            $esrdPatientBalance = DB::select("CALL  collection_analysis_provider($practice_id,'','','','')");
            return new ViewResponse('backend.esrdpatientbalances.index', compact('esrdPatientBalance', 'totalStats'));
        }catch (\Exception $e) {
                return back();
            }
        }
    public function store(Request $request){
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $payer= $request->get('payer');
            $location = $request->get('location');
            $provider = $request->get('provider');
            $esrdPatientBalance = DB::select('CALL collection_analysis_provider(?,?,?,?,?)', array($practice_id, $location, $provider, $payer, ''));
            $view = (string)view('backend.esrdpatientbalances.partials.tableBody', compact('esrdPatientBalance'));

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
