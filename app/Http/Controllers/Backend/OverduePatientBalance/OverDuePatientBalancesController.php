<?php

namespace App\Http\Controllers\Backend\OverduePatientBalance;

use App\Models\OverduePatientBalance\OverDuePatientBalance;
use App\Models\Practice\Practice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\OverduePatientBalance\CreateResponse;
use App\Http\Responses\Backend\OverduePatientBalance\EditResponse;
use App\Repositories\Backend\OverduePatientBalance\OverDuePatientBalanceRepository;
use App\Http\Requests\Backend\OverduePatientBalance\ManageOverDuePatientBalanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * OverDuePatientBalancesController
 */
class OverDuePatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var OverDuePatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param OverDuePatientBalanceRepository $repository;
     */
    public function __construct(OverDuePatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\OverduePatientBalance\ManageOverDuePatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageOverDuePatientBalanceRequest $request)
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $queryCall = DB::select("call aging_summary($practice_id)");
            $collection = collect($queryCall);
            $agingSummaries = $collection->groupBy('Primary_Insurance');
            return new ViewResponse('backend.overduepatientbalances.index', compact('agingSummaries'));
        }catch (\Exception $e) {
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $provider = $request->get('provider');
            $location = $request->get('location');
            $queryCall = DB::select('CALL aging_summary(?,?,?,?,?)', array($practice_id, $location, $provider, '', ''));
            $collection = collect($queryCall);
            $agingSummaries = $collection->groupBy('Primary_Insurance');
            return new ViewResponse('backend.overduepatientbalances.index', compact('agingSummaries'));
        }catch (\Exception $e) {
            return back();
        }

    }
    
}
