<?php

namespace App\Http\Controllers\Backend\PhysicianTwo;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PhysicianTwo\PhysicianTwoRepository;
use App\Http\Requests\Backend\PhysicianTwo\ManagePhysicianTwoRequest;

/**
 * Class PhysicianTwosTableController.
 */
class PhysicianTwosTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianTwoRepository
     */
    protected $physiciantwo;

    /**
     * contructor to initialize repository object
     * @param PhysicianTwoRepository $physiciantwo;
     */
    public function __construct(PhysicianTwoRepository $physiciantwo)
    {
        $this->physiciantwo = $physiciantwo;
    }

    /**
     * This method return the data of the model
     * @param ManagePhysicianTwoRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePhysicianTwoRequest $request)
    {
        return Datatables::of($this->physiciantwo->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($physiciantwo) {
                return Carbon::parse($physiciantwo->created_at)->toDateString();
            })
            ->addColumn('actions', function ($physiciantwo) {
                return $physiciantwo->action_buttons;
            })
            ->make(true);
    }
}
