<?php

namespace App\Http\Controllers\Backend\CkdPatientBalance;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\CkdPatientBalance\CkdPatientBalanceRepository;
use App\Http\Requests\Backend\CkdPatientBalance\ManageCkdPatientBalanceRequest;

/**
 * Class CkdPatientBalancesTableController.
 */
class CkdPatientBalancesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CkdPatientBalanceRepository
     */
    protected $ckdpatientbalance;

    /**
     * contructor to initialize repository object
     * @param CkdPatientBalanceRepository $ckdpatientbalance;
     */
    public function __construct(CkdPatientBalanceRepository $ckdpatientbalance)
    {
        $this->ckdpatientbalance = $ckdpatientbalance;
    }

    /**
     * This method return the data of the model
     * @param ManageCkdPatientBalanceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCkdPatientBalanceRequest $request)
    {
        return Datatables::of($this->ckdpatientbalance->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($ckdpatientbalance) {
                return Carbon::parse($ckdpatientbalance->created_at)->toDateString();
            })
            ->addColumn('actions', function ($ckdpatientbalance) {
                return $ckdpatientbalance->action_buttons;
            })
            ->make(true);
    }
}
