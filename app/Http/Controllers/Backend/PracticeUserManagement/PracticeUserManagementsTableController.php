<?php

namespace App\Http\Controllers\Backend\PracticeUserManagement;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeUserManagement\PracticeUserManagementRepository;
use App\Http\Requests\Backend\PracticeUserManagement\ManagePracticeUserManagementRequest;

/**
 * Class PracticeUserManagementsTableController.
 */
class PracticeUserManagementsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeUserManagementRepository
     */
    protected $practiceusermanagement;

    /**
     * contructor to initialize repository object
     * @param PracticeUserManagementRepository $practiceusermanagement;
     */
    public function __construct(PracticeUserManagementRepository $practiceusermanagement)
    {
        $this->practiceusermanagement = $practiceusermanagement;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeUserManagementRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeUserManagementRequest $request)
    {
        return Datatables::of($this->practiceusermanagement->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practiceusermanagement) {
                return Carbon::parse($practiceusermanagement->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practiceusermanagement) {
                return $practiceusermanagement->action_buttons;
            })
            ->make(true);
    }
}
