<?php

namespace App\Http\Controllers\Backend\Physician1;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Physician1\PhysicianOneRepository;
use App\Http\Requests\Backend\Physician1\ManagePhysicianOneRequest;

/**
 * Class PhysicianOnesTableController.
 */
class PhysicianOnesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianOneRepository
     */
    protected $physicianone;

    /**
     * contructor to initialize repository object
     * @param PhysicianOneRepository $physicianone;
     */
    public function __construct(PhysicianOneRepository $physicianone)
    {
        $this->physicianone = $physicianone;
    }

    /**
     * This method return the data of the model
     * @param ManagePhysicianOneRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePhysicianOneRequest $request)
    {
        return Datatables::of($this->physicianone->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($physicianone) {
                return Carbon::parse($physicianone->created_at)->toDateString();
            })
            ->addColumn('actions', function ($physicianone) {
                return $physicianone->action_buttons;
            })
            ->make(true);
    }
}
