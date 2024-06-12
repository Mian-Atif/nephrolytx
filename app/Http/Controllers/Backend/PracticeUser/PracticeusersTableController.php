<?php

namespace App\Http\Controllers\Backend\PracticeUser;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeUser\PracticeuserRepository;
use App\Http\Requests\Backend\PracticeUser\ManagePracticeuserRequest;

/**
 * Class PracticeusersManagementTableController.
 */
class PracticeusersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeuserRepository
     */
    protected $practiceuser;

    /**
     * contructor to initialize repository object
     * @param PracticeuserRepository $practiceuser;
     */
    public function __construct(PracticeuserRepository $practiceuser)
    {
        $this->practiceuser = $practiceuser;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeuserRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeuserRequest $request)
    {
        return Datatables::of($this->practiceuser->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practiceuser) {
                return Carbon::parse($practiceuser->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practiceuser) {
                return $practiceuser->action_buttons;
            })
            ->make(true);
    }
}
