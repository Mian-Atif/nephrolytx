<?php

namespace App\Http\Controllers\Backend\LocationOne;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\LocationOne\LocationOneRepository;
use App\Http\Requests\Backend\LocationOne\ManageLocationOneRequest;

/**
 * Class LocationOnesTableController.
 */
class LocationOnesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationOneRepository
     */
    protected $locationone;

    /**
     * contructor to initialize repository object
     * @param LocationOneRepository $locationone;
     */
    public function __construct(LocationOneRepository $locationone)
    {
        $this->locationone = $locationone;
    }

    /**
     * This method return the data of the model
     * @param ManageLocationOneRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLocationOneRequest $request)
    {
        return Datatables::of($this->locationone->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($locationone) {
                return Carbon::parse($locationone->created_at)->toDateString();
            })
            ->addColumn('actions', function ($locationone) {
                return $locationone->action_buttons;
            })
            ->make(true);
    }
}
