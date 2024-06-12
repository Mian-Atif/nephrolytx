<?php

namespace App\Http\Controllers\Backend\UserMaintenence;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\UserMaintenence\UserMaintenenceRepository;
use App\Http\Requests\Backend\UserMaintenence\ManageUserMaintenenceRequest;

/**
 * Class UserMaintenencesTableController.
 */
class UserMaintenencesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserMaintenenceRepository
     */
    protected $usermaintenence;

    /**
     * contructor to initialize repository object
     * @param UserMaintenenceRepository $usermaintenence;
     */
    public function __construct(UserMaintenenceRepository $usermaintenence)
    {
        $this->usermaintenence = $usermaintenence;
    }

    /**
     * This method return the data of the model
     * @param ManageUserMaintenenceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageUserMaintenenceRequest $request)
    {
        return Datatables::of($this->usermaintenence->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($usermaintenence) {
                return Carbon::parse($usermaintenence->created_at)->toDateString();
            })
            ->addColumn('actions', function ($usermaintenence) {
                return $usermaintenence->action_buttons;
            })
            ->make(true);
    }
}
