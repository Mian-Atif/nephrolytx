<?php

namespace App\Http\Controllers\Backend\NewCKDPatientBalance;

use App\Models\NewCKDPatientBalance\NewCKDPatientbalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\NewCKDPatientBalance\CreateResponse;
use App\Http\Responses\Backend\NewCKDPatientBalance\EditResponse;
use App\Repositories\Backend\NewCKDPatientBalance\NewCKDPatientbalanceRepository;
use App\Http\Requests\Backend\NewCKDPatientBalance\ManageNewCKDPatientbalanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * NewCKDPatientbalancesController
 */
class NewCKDPatientbalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var NewCKDPatientbalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param NewCKDPatientbalanceRepository $repository;
     */
    public function __construct(NewCKDPatientbalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\NewCKDPatientBalance\ManageNewCKDPatientbalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageNewCKDPatientbalanceRequest $request)
    {
        try {
            $practice_id = Auth::user()->practice_id;
            $locationsWise = DB::select("call collection_analysis_service_location($practice_id,'','','','')");
            return new ViewResponse('backend.newckdpatientbalances.index', compact('locationsWise'));
        }catch (\Exception $e) {
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
            $locationsWise = DB::select('CALL collection_analysis_service_location(?,?,?,?,?)', array($practice_id, $location, $provider, $payer, ''));
            $view = (string)view('backend.newckdpatientbalances.partials.tableBody', compact('locationsWise'));

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
