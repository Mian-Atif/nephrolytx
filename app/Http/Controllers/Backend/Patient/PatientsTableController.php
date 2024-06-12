<?php

namespace App\Http\Controllers\Backend\Patient;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Patient\PatientRepository;
use App\Http\Requests\Backend\Patient\ManagePatientRequest;

/**
 * Class PatientsTableController.
 */
class PatientsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientRepository
     */
    protected $patient;

    /**
     * contructor to initialize repository object
     * @param PatientRepository $patient;
     */
    public function __construct(PatientRepository $patient)
    {
        $this->patient = $patient;
    }

    /**
     * This method return the data of the model
     * @param ManagePatientRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePatientRequest $request)
    {
        return Datatables::of($this->patient->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($patient) {
                return Carbon::parse($patient->created_at)->toDateString();
            })
            ->addColumn('actions', function ($patient) {
                return $patient->action_buttons;
            })
            ->make(true);
    }
}
