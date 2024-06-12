<?php

namespace App\Http\Controllers\Backend\PhysicianThree;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PhysicianThree\PhysicianThreeRepository;
use App\Http\Requests\Backend\PhysicianThree\ManagePhysicianThreeRequest;

/**
 * Class PhysicianThreesTableController.
 */
class PhysicianThreesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianThreeRepository
     */
    protected $physicianthree;

    /**
     * contructor to initialize repository object
     * @param PhysicianThreeRepository $physicianthree;
     */
    public function __construct(PhysicianThreeRepository $physicianthree)
    {
        $this->physicianthree = $physicianthree;
    }

    /**
     * This method return the data of the model
     * @param ManagePhysicianThreeRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePhysicianThreeRequest $request)
    {
        return Datatables::of($this->physicianthree->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($physicianthree) {
                return Carbon::parse($physicianthree->created_at)->toDateString();
            })
            ->addColumn('actions', function ($physicianthree) {
                return $physicianthree->action_buttons;
            })
            ->make(true);
    }
}
