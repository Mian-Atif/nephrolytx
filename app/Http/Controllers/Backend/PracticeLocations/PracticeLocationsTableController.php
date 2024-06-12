<?php

namespace App\Http\Controllers\Backend\PracticeLocations;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeLocations\PracticeLocationRepository;
use App\Http\Requests\Backend\PracticeLocations\ManagePracticeLocationRequest;

/**
 * Class PracticeLocationsTableController.
 */
class PracticeLocationsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeLocationRepository
     */
    protected $practicelocation;

    /**
     * contructor to initialize repository object
     * @param PracticeLocationRepository $practicelocation;
     */
    public function __construct(PracticeLocationRepository $practicelocation)
    {
        $this->practicelocation = $practicelocation;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeLocationRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeLocationRequest $request)
    {
        return Datatables::of($this->practicelocation->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practicelocation) {
                return Carbon::parse($practicelocation->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practicelocation) {
                return $practicelocation->action_buttons;
            })
            ->make(true);
    }
}
