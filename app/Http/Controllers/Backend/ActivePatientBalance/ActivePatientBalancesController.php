<?php

namespace App\Http\Controllers\Backend\ActivePatientBalance;

use App\Models\ActivePatientBalance\ActivePatientBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\ActivePatientBalance\CreateResponse;
use App\Http\Responses\Backend\ActivePatientBalance\EditResponse;
use App\Repositories\Backend\ActivePatientBalance\ActivePatientBalanceRepository;
use App\Http\Requests\Backend\ActivePatientBalance\ManageActivePatientBalanceRequest;

/**
 * ActivePatientBalancesController
 */
class ActivePatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var ActivePatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ActivePatientBalanceRepository $repository;
     */
    public function __construct(ActivePatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\ActivePatientBalance\ManageActivePatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageActivePatientBalanceRequest $request)
    {

        return new ViewResponse('backend.activepatientbalances.index');
    }
    
}
