<?php

namespace App\Http\Controllers\Backend\Procedure;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Procedure\ProcedureRepository;
use App\Http\Requests\Backend\Procedure\ManageProcedureRequest;

/**
 * Class ProceduresTableController.
 */
class ProceduresTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProcedureRepository
     */
    protected $procedure;

    /**
     * contructor to initialize repository object
     * @param ProcedureRepository $procedure;
     */
    public function __construct(ProcedureRepository $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * This method return the data of the model
     * @param ManageProcedureRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProcedureRequest $request)
    {
        return Datatables::of($this->procedure->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($procedure) {
                return Carbon::parse($procedure->created_at)->toDateString();
            })
            ->addColumn('actions', function ($procedure) {
                return $procedure->action_buttons;
            })
            ->make(true);
    }
}
