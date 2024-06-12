<?php

namespace App\Http\Controllers\Backend\NewCKDPatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\NewCKDPatientBalance\NewCKDPatientbalanceRepository;
use App\Http\Requests\Backend\NewCKDPatientBalance\ManageNewCKDPatientbalanceRequest;

/**
 * Class NewCKDPatientbalancesTableController.
 */
class NewCKDPatientbalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var NewCKDPatientbalanceRepository
     */
    protected $newckdpatientbalance;

    /**
     * contructor to initialize repository object
     * @param NewCKDPatientbalanceRepository $newckdpatientbalance;
     */
    public function __construct(NewCKDPatientbalanceRepository $newckdpatientbalance)
    {
        $this->newckdpatientbalance = $newckdpatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageNewCKDPatientbalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageNewCKDPatientbalanceRequest $request)
    {
        return Datatables::of($this->newckdpatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($newckdpatientbalance) {
                return Carbon::parse($newckdpatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($newckdpatientbalance) {
                return $newckdpatientbalance->action_buttons;
            })
            ->make(true);
    }
}
