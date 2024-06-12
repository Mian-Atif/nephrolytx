<?php

namespace App\Http\Controllers\Backend\CptCode;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\CptCode\CptCodeRepository;
use App\Http\Requests\Backend\CptCode\ManageCptCodeRequest;

/**
 * Class CptCodesTableController.
 */
class CptCodesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CptCodeRepository
     */
    protected $cptcode;

    /**
     * contructor to initialize repository object
     * @param CptCodeRepository $cptcode;
     */
    public function __construct(CptCodeRepository $cptcode)
    {
        $this->cptcode = $cptcode;
    }

    /**
     * This method return the data of the model
     * @param ManageCptCodeRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCptCodeRequest $request)
    {
        return Datatables::of($this->cptcode->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($cptcode) {
                return Carbon::parse($cptcode->created_at)->toDateString();
            })
            ->addColumn('actions', function ($cptcode) {
                return $cptcode->action_buttons;
            })
            ->make(true);
    }
}
