<?php

namespace App\Http\Controllers\Backend\PracticeManagement;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeManagement\PracticeManagementRepository;
use App\Http\Requests\Backend\PracticeManagement\ManagePracticeManagementRequest;

/**
 * Class PracticeManagementsTableController.
 */
class PracticeManagementsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeManagementRepository
     */
    protected $practicemanagement;

    /**
     * contructor to initialize repository object
     * @param PracticeManagementRepository $practicemanagement;
     */
    public function __construct(PracticeManagementRepository $practicemanagement)
    {
        $this->practicemanagement = $practicemanagement;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeManagementRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeManagementRequest $request)
    {
        return Datatables::of($this->practicemanagement->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practicemanagement) {
                return Carbon::parse($practicemanagement->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practicemanagement) {
                return $practicemanagement->action_buttons;
            })
            ->make(true);
    }
}
