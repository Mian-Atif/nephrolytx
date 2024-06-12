<?php

namespace App\Http\Controllers\Backend\Prayer;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Prayer\PrayerRepository;
use App\Http\Requests\Backend\Prayer\ManagePrayerRequest;

/**
 * Class PrayersTableController.
 */
class PrayersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PrayerRepository
     */
    protected $prayer;

    /**
     * contructor to initialize repository object
     * @param PrayerRepository $prayer;
     */
    public function __construct(PrayerRepository $prayer)
    {
        $this->prayer = $prayer;
    }

    /**
     * This method return the data of the model
     * @param ManagePrayerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePrayerRequest $request)
    {
        return Datatables::of($this->prayer->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($prayer) {
                return Carbon::parse($prayer->created_at)->toDateString();
            })
            ->addColumn('actions', function ($prayer) {
                return $prayer->action_buttons;
            })
            ->make(true);
    }
}
