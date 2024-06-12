<?php

namespace App\Http\Controllers\Backend\PatientDeductible;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PatientDeductible\PatientDeductibleRepository;
use App\Http\Requests\Backend\PatientDeductible\ManagePatientDeductibleRequest;

/**
 * Class PatientDeductiblesTableController.
 */
class PatientDeductiblesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientDeductibleRepository
     */
    protected $patientdeductible;

    /**
     * contructor to initialize repository object
     * @param PatientDeductibleRepository $patientdeductible;
     */
    public function __construct(PatientDeductibleRepository $patientdeductible)
    {
        $this->patientdeductible = $patientdeductible;
    }

    /**
     * This method return the data of the model
     * @param ManagePatientDeductibleRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePatientDeductibleRequest $request)
    {
        return Datatables::of($this->patientdeductible->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($patientdeductible) {
                return Carbon::parse($patientdeductible->created_at)->toDateString();
            })
            ->addColumn('actions', function ($patientdeductible) {
                return $patientdeductible->action_buttons;
            })
            ->make(true);
    }
}
