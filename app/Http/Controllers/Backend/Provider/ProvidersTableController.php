<?php

namespace App\Http\Controllers\Backend\Provider;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Provider\ProviderRepository;
use App\Http\Requests\Backend\Provider\ManageProviderRequest;

/**
 * Class ProvidersTableController.
 */
class ProvidersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProviderRepository
     */
    protected $provider;

    /**
     * contructor to initialize repository object
     * @param ProviderRepository $provider;
     */
    public function __construct(ProviderRepository $provider)
    {
        $this->provider = $provider;
    }

    /**
     * This method return the data of the model
     * @param ManageProviderRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProviderRequest $request)
    {
        return Datatables::of($this->provider->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($provider) {
                return Carbon::parse($provider->created_at)->toDateString();
            })
            ->addColumn('actions', function ($provider) {
                return $provider->action_buttons;
            })
            ->make(true);
    }
}
