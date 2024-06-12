<?php

namespace App\Http\Controllers\Backend\PatientPayments;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PatientPayments\PatientPaymentRepository;
use App\Http\Requests\Backend\PatientPayments\ManagePatientPaymentRequest;

/**
 * Class PatientPaymentsTableController.
 */
class PatientPaymentsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientPaymentRepository
     */
    protected $patientpayment;

    /**
     * contructor to initialize repository object
     * @param PatientPaymentRepository $patientpayment;
     */
    public function __construct(PatientPaymentRepository $patientpayment)
    {
        $this->patientpayment = $patientpayment;
    }

    /**
     * This method return the data of the model
     * @param ManagePatientPaymentRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePatientPaymentRequest $request)
    {
        return Datatables::of($this->patientpayment->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($patientpayment) {
                return Carbon::parse($patientpayment->created_at)->toDateString();
            })
            ->addColumn('actions', function ($patientpayment) {
                return $patientpayment->action_buttons;
            })
            ->make(true);
    }
}
