<?php

namespace App\Http\Controllers\Backend\LocationThree;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\LocationThree\LocationThreeRepository;
use App\Http\Requests\Backend\LocationThree\ManageLocationThreeRequest;

/**
 * Class LocationThreesTableController.
 */
class LocationThreesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationThreeRepository
     */
    protected $locationthree;

    /**
     * contructor to initialize repository object
     * @param LocationThreeRepository $locationthree;
     */
    public function __construct(LocationThreeRepository $locationthree)
    {
        $this->locationthree = $locationthree;
    }

    /**
     * This method return the data of the model
     * @param ManageLocationThreeRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLocationThreeRequest $request)
    {
        return Datatables::of($this->locationthree->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($locationthree) {
                return Carbon::parse($locationthree->created_at)->toDateString();
            })
            ->addColumn('actions', function ($locationthree) {
                return $locationthree->action_buttons;
            })
            ->make(true);
    }
}
