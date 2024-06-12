<?php

namespace App\Http\Controllers\Backend\PracticeProfile;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeProfile\PracticeProfileRepository;
use App\Http\Requests\Backend\PracticeProfile\ManagePracticeProfileRequest;

/**
 * Class PracticeProfilesTableController.
 */
class PracticeProfilesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeProfileRepository
     */
    protected $practiceprofile;

    /**
     * contructor to initialize repository object
     * @param PracticeProfileRepository $practiceprofile;
     */
    public function __construct(PracticeProfileRepository $practiceprofile)
    {
        $this->practiceprofile = $practiceprofile;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeProfileRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeProfileRequest $request)
    {
        return Datatables::of($this->practiceprofile->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practiceprofile) {
                return Carbon::parse($practiceprofile->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practiceprofile) {
                return $practiceprofile->action_buttons;
            })
            ->make(true);
    }
}
