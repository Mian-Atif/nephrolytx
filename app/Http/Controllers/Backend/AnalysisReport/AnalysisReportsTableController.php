<?php

namespace App\Http\Controllers\Backend\AnalysisReport;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\AnalysisReport\AnalysisReportRepository;
use App\Http\Requests\Backend\AnalysisReport\ManageAnalysisReportRequest;

/**
 * Class AnalysisReportsTableController.
 */
class AnalysisReportsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var AnalysisReportRepository
     */
    protected $analysisreport;

    /**
     * contructor to initialize repository object
     * @param AnalysisReportRepository $analysisreport;
     */
    public function __construct(AnalysisReportRepository $analysisreport)
    {
        $this->analysisreport = $analysisreport;
    }

    /**
     * This method return the data of the model
     * @param ManageAnalysisReportRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageAnalysisReportRequest $request)
    {
        return Datatables::of($this->analysisreport->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($analysisreport) {
                return Carbon::parse($analysisreport->created_at)->toDateString();
            })
            ->addColumn('actions', function ($analysisreport) {
                return $analysisreport->action_buttons;
            })
            ->make(true);
    }
}
