<?php

namespace App\Http\Controllers\Backend\UploadReportsData;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\UploadReportsData\UploadReportsDatumRepository;
use App\Http\Requests\Backend\UploadReportsData\ManageUploadReportsDatumRequest;

/**
 * Class UploadReportsDataTableController.
 */
class UploadReportsDataTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var UploadReportsDatumRepository
     */
    protected $uploadreportsdatum;

    /**
     * contructor to initialize repository object
     * @param UploadReportsDatumRepository $uploadreportsdatum;
     */
    public function __construct(UploadReportsDatumRepository $uploadreportsdatum)
    {
        $this->uploadreportsdatum = $uploadreportsdatum;
    }

    /**
     * This method return the data of the model
     * @param ManageUploadReportsDatumRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageUploadReportsDatumRequest $request)
    {
        return Datatables::of($this->uploadreportsdatum->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($uploadreportsdatum) {
                return Carbon::parse($uploadreportsdatum->created_at)->toDateString();
            })
            ->addColumn('actions', function ($uploadreportsdatum) {
                return $uploadreportsdatum->action_buttons;
            })
            ->make(true);
    }
}
