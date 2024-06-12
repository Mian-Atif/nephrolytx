<?php

namespace App\Http\Controllers\Backend\ESRDPatientName;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\ESRDPatientName\ESRDPatientRepository;
use App\Http\Requests\Backend\ESRDPatientName\ManageESRDPatientRequest;

/**
 * Class ESRDPatientsTableController.
 */
class ESRDPatientsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ESRDPatientRepository
     */
    protected $esrdpatient;

    /**
     * contructor to initialize repository object
     * @param ESRDPatientRepository $esrdpatient;
     */
    public function __construct(ESRDPatientRepository $esrdpatient)
    {
        $this->esrdpatient = $esrdpatient;
    }

    /**
     * This method return the data of the model
     * @param ManageESRDPatientRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageESRDPatientRequest $request)
    {
        return Datatables::of($this->esrdpatient->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($esrdpatient) {
                return Carbon::parse($esrdpatient->created_at)->toDateString();
            })
            ->addColumn('actions', function ($esrdpatient) {
                return $esrdpatient->action_buttons;
            })
            ->make(true);
    }
}
