<?php

namespace App\Http\Controllers\Backend\EsrdPatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\EsrdPatientBalance\ESRDPatientBalanceRepository;
use App\Http\Requests\Backend\EsrdPatientBalance\ManageESRDPatientBalanceRequest;

/**
 * Class ESRDPatientBalancesTableController.
 */
class ESRDPatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ESRDPatientBalanceRepository
     */
    protected $esrdpatientbalance;

    /**
     * contructor to initialize repository object
     * @param ESRDPatientBalanceRepository $esrdpatientbalance;
     */
    public function __construct(ESRDPatientBalanceRepository $esrdpatientbalance)
    {
        $this->esrdpatientbalance = $esrdpatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageESRDPatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageESRDPatientBalanceRequest $request)
    {
        return Datatables::of($this->esrdpatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($esrdpatientbalance) {
                return Carbon::parse($esrdpatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($esrdpatientbalance) {
                return $esrdpatientbalance->action_buttons;
            })
            ->make(true);
    }
}
