<?php

namespace App\Http\Controllers\Backend\PerformanceReport;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PerformanceReport\PerformanceReportRepository;
use App\Http\Requests\Backend\PerformanceReport\ManagePerformanceReportRequest;

/**
 * Class PerformanceReportsTableController.
 */
class PerformanceReportsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PerformanceReportRepository
     */
    protected $performancereport;

    /**
     * contructor to initialize repository object
     * @param PerformanceReportRepository $performancereport;
     */
    public function __construct(PerformanceReportRepository $performancereport)
    {
        $this->performancereport = $performancereport;
    }

    /**
     * This method return the data of the model
     * @param ManagePerformanceReportRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePerformanceReportRequest $request)
    {
        return Datatables::of($this->performancereport->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($performancereport) {
                return Carbon::parse($performancereport->created_at)->toDateString();
            })
            ->addColumn('actions', function ($performancereport) {
                return $performancereport->action_buttons;
            })
            ->make(true);
    }
}
