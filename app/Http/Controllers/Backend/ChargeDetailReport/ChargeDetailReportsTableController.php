<?php

namespace App\Http\Controllers\Backend\ChargeDetailReport;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\ChargeDetailReport\ChargeDetailReportRepository;
use App\Http\Requests\Backend\ChargeDetailReport\ManageChargeDetailReportRequest;

/**
 * Class ChargeDetailReportsTableController.
 */
class ChargeDetailReportsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChargeDetailReportRepository
     */
    protected $chargedetailreport;

    /**
     * contructor to initialize repository object
     * @param ChargeDetailReportRepository $chargedetailreport;
     */
    public function __construct(ChargeDetailReportRepository $chargedetailreport)
    {
        $this->chargedetailreport = $chargedetailreport;
    }

    /**
     * This method return the data of the model
     * @param ManageChargeDetailReportRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageChargeDetailReportRequest $request)
    {
        return Datatables::of($this->chargedetailreport->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($chargedetailreport) {
                return Carbon::parse($chargedetailreport->created_at)->toDateString();
            })
            ->addColumn('actions', function ($chargedetailreport) {
                return $chargedetailreport->action_buttons;
            })
            ->make(true);
    }
}
