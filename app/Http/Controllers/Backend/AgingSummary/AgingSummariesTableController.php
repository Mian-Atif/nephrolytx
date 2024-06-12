<?php

namespace App\Http\Controllers\Backend\AgingSummary;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\AgingSummary\AgingSummaryRepository;
use App\Http\Requests\Backend\AgingSummary\ManageAgingSummaryRequest;

/**
 * Class AgingSummariesTableController.
 */
class AgingSummariesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var AgingSummaryRepository
     */
    protected $agingsummary;

    /**
     * contructor to initialize repository object
     * @param AgingSummaryRepository $agingsummary;
     */
    public function __construct(AgingSummaryRepository $agingsummary)
    {
        $this->agingsummary = $agingsummary;
    }

    /**
     * This method return the data of the model
     * @param ManageAgingSummaryRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageAgingSummaryRequest $request)
    {
        return Datatables::of($this->agingsummary->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($agingsummary) {
                return Carbon::parse($agingsummary->created_at)->toDateString();
            })
            ->addColumn('actions', function ($agingsummary) {
                return $agingsummary->action_buttons;
            })
            ->make(true);
    }
}
