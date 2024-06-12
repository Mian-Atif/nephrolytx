<?php

namespace App\Http\Controllers\Backend\ActivePatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\ActivePatientBalance\ActivePatientBalanceRepository;
use App\Http\Requests\Backend\ActivePatientBalance\ManageActivePatientBalanceRequest;

/**
 * Class ActivePatientBalancesTableController.
 */
class ActivePatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ActivePatientBalanceRepository
     */
    protected $activepatientbalance;

    /**
     * contructor to initialize repository object
     * @param ActivePatientBalanceRepository $activepatientbalance;
     */
    public function __construct(ActivePatientBalanceRepository $activepatientbalance)
    {
        $this->activepatientbalance = $activepatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageActivePatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageActivePatientBalanceRequest $request)
    {
        return Datatables::of($this->activepatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($activepatientbalance) {
                return Carbon::parse($activepatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($activepatientbalance) {
                return $activepatientbalance->action_buttons;
            })
            ->make(true);
    }
}
