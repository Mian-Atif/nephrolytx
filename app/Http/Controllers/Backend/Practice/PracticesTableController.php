<?php

namespace App\Http\Controllers\Backend\Practice;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Practice\PracticeRepository;
use App\Http\Requests\Backend\Practice\ManagePracticeRequest;

/**
 * Class PracticesTableController.
 */
class PracticesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeRepository
     */
    protected $practice;

    /**
     * contructor to initialize repository object
     * @param PracticeRepository $practice;
     */
    public function __construct(PracticeRepository $practice)
    {
        $this->practice = $practice;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeRequest $request)
    {
        return Datatables::make($this->practice->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('middle_name', function ($practice) {
                return $practice->middle_name;
            })
            ->addColumn('email', function ($practice) {
                return $practice->email;
            })
            ->addColumn('owner', function ($practice) {
                return $practice->owner;
            })
            ->addColumn('type', function ($practice) {
                return $practice->type;
            })
            ->addColumn('created_at', function ($practice) {
                return Carbon::parse($practice->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practice) {
                return $practice->action_buttons;
            })
            ->rawColumns(['actions', 'action','action_buttons'])
            ->make(true);
    }
}
