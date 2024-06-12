<?php

namespace App\Http\Controllers\Backend\TotalActivePatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\TotalActivePatientBalance\TotalActivePatientBalanceRepository;
use App\Http\Requests\Backend\TotalActivePatientBalance\ManageTotalActivePatientBalanceRequest;

/**
 * Class TotalActivePatientBalancesTableController.
 */
class TotalActivePatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TotalActivePatientBalanceRepository
     */
    protected $totalactivepatientbalance;

    /**
     * contructor to initialize repository object
     * @param TotalActivePatientBalanceRepository $totalactivepatientbalance;
     */
    public function __construct(TotalActivePatientBalanceRepository $totalactivepatientbalance)
    {
        $this->totalactivepatientbalance = $totalactivepatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageTotalActivePatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageTotalActivePatientBalanceRequest $request)
    {
        return Datatables::of($this->totalactivepatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($totalactivepatientbalance) {
                return Carbon::parse($totalactivepatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($totalactivepatientbalance) {
                return $totalactivepatientbalance->action_buttons;
            })
            ->make(true);
    }
}
