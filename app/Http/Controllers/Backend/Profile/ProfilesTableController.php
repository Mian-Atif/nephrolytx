<?php

namespace App\Http\Controllers\Backend\Profile;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Profile\ProfileRepository;
use App\Http\Requests\Backend\Profile\ManageProfileRequest;

/**
 * Class ProfilesTableController.
 */
class ProfilesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProfileRepository
     */
    protected $profile;

    /**
     * contructor to initialize repository object
     * @param ProfileRepository $profile;
     */
    public function __construct(ProfileRepository $profile)
    {
        $this->profile = $profile;
    }

    /**
     * This method return the data of the model
     * @param ManageProfileRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProfileRequest $request)
    {
        return Datatables::of($this->profile->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($profile) {
                return Carbon::parse($profile->created_at)->toDateString();
            })
            ->addColumn('actions', function ($profile) {
                return $profile->action_buttons;
            })
            ->make(true);
    }
}
