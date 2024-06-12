<?php

namespace App\Http\Controllers\Backend\ChargeAndCollectionSummary;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\ChargeAndCollectionSummary\ChargeAndCollectionSummaryRepository;
use App\Http\Requests\Backend\ChargeAndCollectionSummary\ManageChargeAndCollectionSummaryRequest;

/**
 * Class ChargeAndCollectionSummariesTableController.
 */
class ChargeAndCollectionSummariesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ChargeAndCollectionSummaryRepository
     */
    protected $chargeandcollectionsummary;

    /**
     * contructor to initialize repository object
     * @param ChargeAndCollectionSummaryRepository $chargeandcollectionsummary;
     */
    public function __construct(ChargeAndCollectionSummaryRepository $chargeandcollectionsummary)
    {
        $this->chargeandcollectionsummary = $chargeandcollectionsummary;
    }

    /**
     * This method return the data of the model
     * @param ManageChargeAndCollectionSummaryRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageChargeAndCollectionSummaryRequest $request)
    {
        return Datatables::of($this->chargeandcollectionsummary->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($chargeandcollectionsummary) {
                return Carbon::parse($chargeandcollectionsummary->created_at)->toDateString();
            })
            ->addColumn('actions', function ($chargeandcollectionsummary) {
                return $chargeandcollectionsummary->action_buttons;
            })
            ->make(true);
    }
}
