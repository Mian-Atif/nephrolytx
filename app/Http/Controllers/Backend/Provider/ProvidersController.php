<?php

namespace App\Http\Controllers\Backend\Provider;

use App\Models\Provider\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Provider\CreateResponse;
use App\Http\Responses\Backend\Provider\EditResponse;
use App\Repositories\Backend\Provider\ProviderRepository;
use App\Http\Requests\Backend\Provider\ManageProviderRequest;
use App\Http\Requests\Backend\Provider\CreateProviderRequest;
use App\Http\Requests\Backend\Provider\StoreProviderRequest;
use App\Http\Requests\Backend\Provider\EditProviderRequest;
use App\Http\Requests\Backend\Provider\UpdateProviderRequest;
use App\Http\Requests\Backend\Provider\DeleteProviderRequest;

/**
 * ProvidersController
 */
class ProvidersController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProviderRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProviderRepository $repository;
     */
    public function __construct(ProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Provider\ManageProviderRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageProviderRequest $request)
    {
        return new ViewResponse('backend.providers.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateProviderRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Provider\CreateResponse
     */
    public function create(CreateProviderRequest $request)
    {
        return new CreateResponse('backend.providers.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProviderRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreProviderRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.providers.index'), ['flash_success' => trans('alerts.backend.providers.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Provider\Provider  $provider
     * @param  EditProviderRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Provider\EditResponse
     */
    public function edit(Provider $provider, EditProviderRequest $request)
    {
        return new EditResponse($provider);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProviderRequestNamespace  $request
     * @param  App\Models\Provider\Provider  $provider
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $provider, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.providers.index'), ['flash_success' => trans('alerts.backend.providers.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteProviderRequestNamespace  $request
     * @param  App\Models\Provider\Provider  $provider
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Provider $provider, DeleteProviderRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($provider);
        //returning with successfull message
        return new RedirectResponse(route('admin.providers.index'), ['flash_success' => trans('alerts.backend.providers.deleted')]);
    }
    
}
