<?php

namespace App\Http\Controllers\Backend\BillingManager;

use App\Models\BillingManager\BillingManager;
use App\Models\Person\Person;
use App\Models\Practice\Practice;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\BillingManager\CreateResponse;
use App\Http\Responses\Backend\BillingManager\EditResponse;
use App\Repositories\Backend\BillingManager\BillingManagerRepository;
use App\Http\Requests\Backend\BillingManager\ManageBillingManagerRequest;
use App\Http\Requests\Backend\BillingManager\CreateBillingManagerRequest;
use App\Http\Requests\Backend\BillingManager\StoreBillingManagerRequest;
use App\Http\Requests\Backend\BillingManager\EditBillingManagerRequest;
use App\Http\Requests\Backend\BillingManager\UpdateBillingManagerRequest;
use App\Http\Requests\Backend\BillingManager\DeleteBillingManagerRequest;

/**
 * BillingManagersController
 */
class BillingManagersController extends Controller
{
    /**
     * variable to store the repository object
     * @var BillingManagerRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param BillingManagerRepository $repository;
     */
    public function __construct(BillingManagerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\BillingManager\ManageBillingManagerRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageBillingManagerRequest $request)
    {

        $billingManagers = $this->repository->getBillingManager(Auth::user()->practice_id);
        return new ViewResponse('backend.billingmanagers.index',compact('billingManagers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateBillingManagerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\BillingManager\CreateResponse
     */
    public function create(CreateBillingManagerRequest $request)
    {
        return new CreateResponse('backend.billingmanagers.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBillingManagerRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreBillingManagerRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.billingmanagers.index'), ['flash_success' => trans('alerts.backend.billingmanagers.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\BillingManager\BillingManager  $billingmanager
     * @param  EditBillingManagerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\BillingManager\EditResponse
     */
    public function edit(BillingManager $billingmanager, EditBillingManagerRequest $request)
    {
        return new EditResponse($billingmanager);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBillingManagerRequestNamespace  $request
     * @param  App\Models\BillingManager\BillingManager  $billingmanager
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateBillingManagerRequest $request, BillingManager $billingmanager)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $billingmanager, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.billingmanagers.index'), ['flash_success' => trans('alerts.backend.billingmanagers.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteBillingManagerRequestNamespace  $request
     * @param  App\Models\BillingManager\BillingManager  $billingmanager
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(BillingManager $billingmanager, DeleteBillingManagerRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($billingmanager);
        //returning with successfull message
        return new RedirectResponse(route('admin.billingmanagers.index'), ['flash_success' => trans('alerts.backend.billingmanagers.deleted')]);
    }

    public function addBillingManager(Request $request){
        try{
            $this->repository->addBillingManager($request);
//            return response()->json([
//                'status' => true,
//                'message' => 'Billing Manager Created Successfully!!'
//            ]);

            return redirect()->back()->withFlashSuccess(trans('frontend.auth.add_billing_manager'));
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }

    }

    public  function deleteBillingmanager($id){

        $person = Person::find($id);
        $person->user()->delete();
        BillingManager::where('person_id',$id)->delete();
        $person->delete();

        return response()
            ->json(['code' => 1, 'message' => 'Operation Successful !']);
    }
    public function getBillingMngrModal($id)
    {
        try {
            $practice=Practice::find($id);
            $popup = view('backend.billingmanagers.partials.create-popup',compact('practice'))->render();
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
