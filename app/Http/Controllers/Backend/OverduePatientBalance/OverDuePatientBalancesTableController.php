<?php

namespace App\Http\Controllers\Backend\OverduePatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\OverduePatientBalance\OverDuePatientBalanceRepository;
use App\Http\Requests\Backend\OverduePatientBalance\ManageOverDuePatientBalanceRequest;

/**
 * Class OverDuePatientBalancesTableController.
 */
class OverDuePatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var OverDuePatientBalanceRepository
     */
    protected $overduepatientbalance;

    /**
     * contructor to initialize repository object
     * @param OverDuePatientBalanceRepository $overduepatientbalance;
     */
    public function __construct(OverDuePatientBalanceRepository $overduepatientbalance)
    {
        $this->overduepatientbalance = $overduepatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageOverDuePatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageOverDuePatientBalanceRequest $request)
    {
        return Datatables::of($this->overduepatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($overduepatientbalance) {
                return Carbon::parse($overduepatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($overduepatientbalance) {
                return $overduepatientbalance->action_buttons;
            })
            ->make(true);
    }
}
