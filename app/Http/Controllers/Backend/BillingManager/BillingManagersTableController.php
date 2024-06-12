<?php

namespace App\Http\Controllers\Backend\BillingManager;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\BillingManager\BillingManagerRepository;
use App\Http\Requests\Backend\BillingManager\ManageBillingManagerRequest;

/**
 * Class BillingManagersTableController.
 */
class BillingManagersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var BillingManagerRepository
     */
    protected $billingmanager;

    /**
     * contructor to initialize repository object
     * @param BillingManagerRepository $billingmanager;
     */
    public function __construct(BillingManagerRepository $billingmanager)
    {
        $this->billingmanager = $billingmanager;
    }

    /**
     * This method return the data of the model
     * @param ManageBillingManagerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageBillingManagerRequest $request)
    {
        return Datatables::of($this->billingmanager->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($billingmanager) {
                return Carbon::parse($billingmanager->created_at)->toDateString();
            })
            ->addColumn('actions', function ($billingmanager) {
                return $billingmanager->action_buttons;
            })
            ->make(true);
    }
}
