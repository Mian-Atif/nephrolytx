<?php

namespace App\Http\Controllers\Backend\CptCodeInsurancePrices;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\CptCodeInsurancePrices\CptCodeInsurancePriceRepository;
use App\Http\Requests\Backend\CptCodeInsurancePrices\ManageCptCodeInsurancePriceRequest;

/**
 * Class CptCodeInsurancePricesTableController.
 */
class CptCodeInsurancePricesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CptCodeInsurancePriceRepository
     */
    protected $cptcodeinsuranceprice;

    /**
     * contructor to initialize repository object
     * @param CptCodeInsurancePriceRepository $cptcodeinsuranceprice;
     */
    public function __construct(CptCodeInsurancePriceRepository $cptcodeinsuranceprice)
    {
        $this->cptcodeinsuranceprice = $cptcodeinsuranceprice;
    }

    /**
     * This method return the data of the model
     * @param ManageCptCodeInsurancePriceRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCptCodeInsurancePriceRequest $request)
    {
        return Datatables::of($this->cptcodeinsuranceprice->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($cptcodeinsuranceprice) {
                return Carbon::parse($cptcodeinsuranceprice->created_at)->toDateString();
            })
            ->addColumn('email', function ($person) {
                return $person->email;
            })
            ->addColumn('phone', function ($person) {
                return $person->phone;
            })
            ->addColumn('actions', function ($cptcodeinsuranceprice) {
                return $cptcodeinsuranceprice->action_buttons;
            })
            ->make(true);
    }
}
