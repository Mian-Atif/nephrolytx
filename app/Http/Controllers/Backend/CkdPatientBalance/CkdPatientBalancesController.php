<?php

namespace App\Http\Controllers\Backend\CkdPatientBalance;

use App\Models\CkdPatientBalance\CkdPatientBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\CkdPatientBalance\CreateResponse;
use App\Http\Responses\Backend\CkdPatientBalance\EditResponse;
use App\Repositories\Backend\CkdPatientBalance\CkdPatientBalanceRepository;
use App\Http\Requests\Backend\CkdPatientBalance\ManageCkdPatientBalanceRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * CkdPatientBalancesController
 */
class CkdPatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var CkdPatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CkdPatientBalanceRepository $repository;
     */
    public function __construct(CkdPatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\CkdPatientBalance\ManageCkdPatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCkdPatientBalanceRequest $request)
    {

        $user = Auth::user();
        $practice_id = $user->practice_id;
        $queryCall=DB::select("call collection_payer_wise($practice_id)");
        $collection=collect($queryCall);
        $payers = $collection->groupBy('Primary_Insurance_Name');
        return new ViewResponse('backend.ckdpatientbalances.index',compact('payers'));
    }
    
}
