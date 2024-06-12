<?php

namespace App\Http\Controllers\Backend\LocationTwo;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\LocationTwo\LocationTwoRepository;
use App\Http\Requests\Backend\LocationTwo\ManageLocationTwoRequest;

/**
 * Class LocationTwosTableController.
 */
class LocationTwosTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationTwoRepository
     */
    protected $locationtwo;

    /**
     * contructor to initialize repository object
     * @param LocationTwoRepository $locationtwo;
     */
    public function __construct(LocationTwoRepository $locationtwo)
    {
        $this->locationtwo = $locationtwo;
    }

    /**
     * This method return the data of the model
     * @param ManageLocationTwoRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLocationTwoRequest $request)
    {
        return Datatables::of($this->locationtwo->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($locationtwo) {
                return Carbon::parse($locationtwo->created_at)->toDateString();
            })
            ->addColumn('actions', function ($locationtwo) {
                return $locationtwo->action_buttons;
            })
            ->make(true);
    }
}
