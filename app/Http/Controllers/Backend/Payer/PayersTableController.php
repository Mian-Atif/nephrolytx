<?php

namespace App\Http\Controllers\Backend\Payer;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Payer\PayerRepository;
use App\Http\Requests\Backend\Payer\ManagePayerRequest;

/**
 * Class PayersTableController.
 */
class PayersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PayerRepository
     */
    protected $payer;

    /**
     * contructor to initialize repository object
     * @param PayerRepository $payer;
     */
    public function __construct(PayerRepository $payer)
    {
        $this->payer = $payer;
    }

    /**
     * This method return the data of the model
     * @param ManagePayerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePayerRequest $request)
    {
        return Datatables::of($this->payer->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($payer) {
                return Carbon::parse($payer->created_at)->toDateString();
            })
            ->addColumn('actions', function ($payer) {
                return $payer->action_buttons;
            })
            ->make(true);
    }
}
