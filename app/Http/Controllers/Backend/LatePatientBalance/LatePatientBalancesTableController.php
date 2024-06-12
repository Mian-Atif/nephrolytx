<?php

namespace App\Http\Controllers\Backend\LatePatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\LatePatientBalance\LatePatientBalanceRepository;
use App\Http\Requests\Backend\LatePatientBalance\ManageLatePatientBalanceRequest;

/**
 * Class LatePatientBalancesTableController.
 */
class LatePatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LatePatientBalanceRepository
     */
    protected $latepatientbalance;

    /**
     * contructor to initialize repository object
     * @param LatePatientBalanceRepository $latepatientbalance;
     */
    public function __construct(LatePatientBalanceRepository $latepatientbalance)
    {
        $this->latepatientbalance = $latepatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageLatePatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLatePatientBalanceRequest $request)
    {
        return Datatables::of($this->latepatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($latepatientbalance) {
                return Carbon::parse($latepatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($latepatientbalance) {
                return $latepatientbalance->action_buttons;
            })
            ->make(true);
    }
}
