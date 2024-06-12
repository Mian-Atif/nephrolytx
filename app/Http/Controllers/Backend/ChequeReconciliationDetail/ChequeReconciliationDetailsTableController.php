<?php

namespace App\Http\Controllers\Backend\ChequeReconciliationDetail;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\ChequeReconciliationDetail\ChequeReconciliationDetailRepository;
use App\Http\Requests\Backend\ChequeReconciliationDetail\ManageChequeReconciliationDetailRequest;

/**
 * Class ChequeReconciliationDetailsTableController.
 */
class ChequeReconciliationDetailsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChequeReconciliationDetailRepository
     */
    protected $chequereconciliationdetail;

    /**
     * contructor to initialize repository object
     * @param ChequeReconciliationDetailRepository $chequereconciliationdetail;
     */
    public function __construct(ChequeReconciliationDetailRepository $chequereconciliationdetail)
    {
        $this->chequereconciliationdetail = $chequereconciliationdetail;
    }

    /**
     * This method return the data of the model
     * @param ManageChequeReconciliationDetailRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageChequeReconciliationDetailRequest $request)
    {
        return Datatables::of($this->chequereconciliationdetail->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($chequereconciliationdetail) {
                return Carbon::parse($chequereconciliationdetail->created_at)->toDateString();
            })
            ->addColumn('actions', function ($chequereconciliationdetail) {
                return $chequereconciliationdetail->action_buttons;
            })
            ->make(true);
    }
}
