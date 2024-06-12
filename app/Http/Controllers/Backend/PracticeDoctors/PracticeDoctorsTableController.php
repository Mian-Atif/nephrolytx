<?php

namespace App\Http\Controllers\Backend\PracticeDoctors;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PracticeDoctors\PracticeDoctorRepository;
use App\Http\Requests\Backend\PracticeDoctors\ManagePracticeDoctorRequest;

/**
 * Class PracticeDoctorsTableController.
 */
class PracticeDoctorsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeDoctorRepository
     */
    protected $practicedoctor;

    /**
     * contructor to initialize repository object
     * @param PracticeDoctorRepository $practicedoctor;
     */
    public function __construct(PracticeDoctorRepository $practicedoctor)
    {
        $this->practicedoctor = $practicedoctor;
    }

    /**
     * This method return the data of the model
     * @param ManagePracticeDoctorRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePracticeDoctorRequest $request)
    {
        return Datatables::of($this->practicedoctor->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($practicedoctor) {
                return Carbon::parse($practicedoctor->created_at)->toDateString();
            })
            ->addColumn('actions', function ($practicedoctor) {
                return $practicedoctor->action_buttons;
            })
            ->make(true);
    }
}
